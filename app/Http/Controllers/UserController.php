<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Event;
use App\Models\User;
use App\Models\Student;
use App\Models\Group;
use App\Models\Payment;
use App\Models\FreeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laravel\Cashier\Exceptions\IncompletePayment;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (Auth::user()->role != "admin" && Auth::user()->role != "teacher") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $users = User::where("id", ">", 0);
        if ($request->input("search")) {
            $search = explode(" ", $request->input("search"));
            if (count($search) > 1) { // Trying to split name and surname
                $users = $users->where("name", "LIKE", "%".$request->input("search")."%");
            } else {
                $users = $users->where("name", "LIKE", "%".$request->input("search")."%")->orWhere("email", "LIKE",
                    "%".$request->input("search")."%");
            }
        }
        if ($request->input("role") && $request->input("role") !== "showall") {
            $users = $users->where("role", "LIKE", $request->role);
        }

        if (Auth::user()->role === 'teacher') {
            $users->whereHas('students', function ($q) {
                $q->whereIn('group_id', Auth::user()->getGroups()->pluck('id'));
                $q->where('user_id', '!=', 15);
                $q->where('user_id', '!=', 23);
            });
        }


        return view("dashboard.users.index")->with("users",
            $users->orderBy("id", "DESC")->paginate(15)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.users.create")->with("groups", Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'country' => 'required|string|max:255',
        ]);

        $user = new User;
        $user->name = $request->input("name");
        $user->surname = $request->input("surname");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
        $user->country = $request->input("country");
        $user->role = $request->input("role");
        $user->terms = 1;

        $user->save();

        Session::flash('message', "Paskyra sėkmingai pridėta");
        return Redirect::to('dashboard/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {

        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        if (empty($user)) {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.users.show")->with("user", $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.users.edit")->with("user", $user)->with("groups", Group::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $user->name = $request->input("name");
        $user->surname = $request->input("surname");
        $user->country = $request->input("country");
        $user->role = $request->input("role");

        $user->save();

        Session::flash('message', "Paskyra sėkmingai atnaujinta");
        return Redirect::to('dashboard/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $user->delete();
        Session::flash('message', "Paskyra sėkmingai ištrinta");
        return Redirect::to('dashboard/users');
    }

    public static function hasGroup() {
        if (Auth::user()->role != "user") {
            return true;
        }
        foreach (Auth::user()->students as $student) {
            if ($student->group) {
                return true;
            }
        }
        return false;
    }

    public static function hasDemoLesson() {
        foreach (Auth::user()->students as $student) {
            if ($student->group != null) {
                if ($student->group->type != "free") {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function export() {
        return \Excel::download(new UsersExport, 'users.xlsx');
    }

    public function setRegion(Request $request) {
        if (!empty(Auth::user())) {
            Auth::user()->time_zone = $request->input("timezone");
            Auth::user()->save();
        }
        \Cookie::queue('user_timezone', $request->input("timezone"), 60 * 24 * 365);
        return redirect($request->input("url"));
    }

    public function clearRegion(Request $request) {
        \Cookie::queue(\Cookie::forget('user_timezone'));
        \Cookie::queue(\Cookie::forget('user_region'));
        return view('landing.main');
    }


    public function registerFree(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'country' => 'required|string|max:255',
            'student_age' => 'required',
            'terms' => 'required',
        ]);


        $freeRegistration = new FreeRegistration;
        $freeRegistration->name = $request->input("name");
        $freeRegistration->student_name = $request->input("student_name");
        $freeRegistration->student_age = $request->input("student_age");
        $freeRegistration->email = $request->input("email");
        $freeRegistration->country = $request->input("country");
        $freeRegistration->comment = $request->input("comments", "");
        $freeRegistration->newsletter = $request->input("newsletter", 0);
        $freeRegistration->save();


        $name = explode(" ", $request->input("name"));

        if ($request->newsletter) {
            $mailchimpData = [
                'email' => $request->email,
                'status' => 'subscribed',
                'firstname' => $name[0],
                'lastname' => str_replace($name[0]."", "", $request->input("name")),
            ];

            RegisteredUserController::syncMailchimp($mailchimpData);
        }

//        $password = Str::random(16);
//
//        $user = new User;
//        $user->name = $name[0];
//        $user->surname = str_replace($name[0]."", "", $request->input("name"));
//        $user->email = $request->input("email");
//        $user->password = Hash::make($password);
//        $user->country = $request->input("country");
//        $user->role = "user";
//        $user->terms = $request->input("terms");
//
//        $user->save();
//
//        $free_group = Group::where("type", "free")->orderBy("id","DESC")->first();
//
//        $student = new Student;
//        $student->name = $request->input("student_name");
//        $student->user_id = $user->id;
//        $student->group_id = $free_group ? $free_group->id : -1;
//        $student->save();
//
//        Auth::login($user); // prijungia paskyrą prie dabartinės sesijos

//        $modal_title = "Jūs sėkmingai užsiregistravote!";
//        $modal_content = "Jūsų paskyra sėkmingai sukurta, Jūs buvote priskirtas į nemokamos pamokos grupę.<br><br>Prisijungimo vardas: ".$request->input("email").
//            "<br>Slaptažodis: ".$password."<br><br>Detalesnė paskyros informacija atsiųsta Jums el. paštu<br><br><a class='button' href='/dashboard'>Prisijungti</a>";
//
//        $email_title = "Registracija prie nemokamos pamokos";
//        $email_content = "<h1>Sveikiname prisijungus!</h1><p>Prisijungti galite čia: <a href='".\Config::get('app.url')."/login'>".\Config::get('app.url')."/login</a><br>Prisijungimo vardas: ".$request->input("email")."<br>Slaptažodis: $password</p>".
//            "<p>Jūsų vardas: ".$request->input("name")."<br>Vaiko vardas: ".$request->input("student_name")."<br>Vaiko amžius: ".$request->input("student_age")."<br>Komentaras: ". $request->input("comment")."</p>";
//
//        $email_title_admin = "Registracija prie nemokamos pamokos";
//        $email_content_admin = "<h1>Naujas prisijungimas prie nemokamos pamokos!</h1><p>El. paštas: ".$request->input("email")."<br>Vardas: ".$request->input("name")."<br>Vaiko vardas: ".$request->input("student_name")."<br>Vaiko amžius: ".$request->input("student_age")."<br>Komentaras: ". $request->input("comment")."</p>";

        $modal_title = "Jūs sėkmingai užsiregistravote!";
        $modal_content = "Netrukus susisieksime. Ačiū, kad domitės Pasaka!";

        $email_title = "Registracijos į nemokamą pamoką patvirtinimas";
        $email_content = "<p>Ačiū, kad užpildėte anketą. Susisieksime netrukus!</p><p>Pasaka</p>";

        $email_title_admin = "Registracija prie nemokamos pamokos";
        $email_content_admin = "<h1>Naujas formos užpildymas prie nemokamos pamokos!</h1><p>El. paštas: ".$request->input("email")."<br>Vardas: ".$request->input("name")."<br>Vaiko vardas: ".$request->input("student_name")."<br>Vaiko amžius: ".$request->input("student_age")."<br>Šalis: ".$request->input("country")."<br>Komentaras: ".$request->input("comments")."</p>";

        $email = $request->email;

        \Mail::send([], [], function ($message) use ($email_title, $email_content, $email) {
            $message
                ->to($email)
                ->subject($email_title)
                ->setBody($email_content, 'text/html');
        });
        \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin) {
            $message
                ->to(\Config::get('app.email'))
                ->subject($email_title_admin)
                ->setBody($email_content_admin, 'text/html');
        });


        Session::flash('modal_title', $modal_title);
        Session::flash('modal_content', $modal_content);
        return Redirect::back();

        // return view("landing.nemokama_pamoka")->with("modal_title", $modal_title)->with("modal_content", $modal_content);
    }

    public function profile(Request $request) {
        return view("dashboard.profile")->with("intent", Auth::user()->createSetupIntent());
    }

    public function selectGroup(Request $request, $id) {
        $group = Group::find($id);
        if (!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

        $intent = null;
        if (Auth::check()) {
            Auth::user()->createOrGetStripeCustomer();
            $intent = Auth::user()->createSetupIntent();
        }

        return view("landing_other.group_order")->with("group", $group)->with("intent", $intent);
    }

    public function selectGroupOrder(Request $request, $id) {
        $group = Group::find($id);
        if (!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

//        $intent = null;
        if (Auth::check()) {
//            Auth::user()->createOrGetStripeCustomer();
//            $intent = Auth::user()->createSetupIntent();
        }

        return view("lessons_order.group_create_order")->with("group", $group);
    }


    public function updateCard(Request $request) {
        Auth::user()->updateDefaultPaymentMethod($request->input("payment_method"));

        return json_encode(["message" => "Kortelė išsaugota", "card_last" => Auth::user()->card_last_four]);
    }

    public function zoom(Request $request) {
        $code = $request->input("code");

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://zoom.us/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=$code&redirect_uri=".\Config::get('app.url')."/dashboard/profile/zoom",
            CURLOPT_HTTPHEADER => [
                "authorization: Basic ".base64_encode(env("ZOOM_CLIENT_ID").":".env("ZOOM_CLIENT_SECRET")),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            die("cURL Error #:".$err);
        }

        $response = json_decode($response);
        $access_token = $response->access_token;
        $user = Auth::user();
        $user->zoom_access_token = $access_token;
        $user->save();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.zoom.us/v2/users/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer ".$access_token,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            die("cURL Error #:".$err);
        }

        $response = json_decode($response);

        $user_id = $response->id;
        $user->zoom_user_id = $user_id;
        $user->save();

        if (session('zoom_group_meeting')) {
            $event = Event::find(session('zoom_group_meeting'));

            if (!$event->zoom_meeting_id) {
                $curl = curl_init();

                $meetingInfo = [];
                $meetingInfo["topic"] = $event->name;
                $meetingInfo["type"] = 1;
                $meetingInfo["agenda"] = strip_tags($event->description);
                $meetingInfo["settings"] = [];
                $meetingInfo["settings"]["host_vide"] = true;
                $meetingInfo["settings"]["participant_video"] = false;
                $meetingInfo["settings"]["cn_meeting"] = false;
                $meetingInfo["settings"]["in_meeting"] = false;
                $meetingInfo["settings"]["mute_upon_entry"] = false;
                $meetingInfo["settings"]["watermark"] = false;
                $meetingInfo["settings"]["use_pmi"] = false;
                $meetingInfo["settings"]["approval_type"] = 0;
                $meetingInfo["settings"]["audio"] = "both";
                $meetingInfo["settings"]["auto_recording"] = "none";
                $meetingInfo["settings"]["close_registration"] = false;
                $meetingInfo["settings"]["waiting_room"] = true;
                $meetingInfo["settings"]["contact_name"] = \Config::get('app.email');
                $meetingInfo["settings"]["contact_email"] = \Config::get('app.email');
                $meetingInfo["settings"]["meeting_authentication"] = false;


                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.zoom.us/v2/users/".$user_id."/meetings",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($meetingInfo),
                    CURLOPT_HTTPHEADER => [
                        "authorization: Bearer ".$access_token,
                        "content-type: application/json",
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:".$err;
                }

                $response = json_decode($response);
                $event->zoom_meeting_id = $response->id;
                $event->zoom_meeting_password = $response->password;
                $event->save();

                return redirect("/dashboard/groups/".$event->groups[0]->id);
            }
        }

        return view("dashboard.profile")->with("intent", Auth::user()->createSetupIntent())->with("message",
            "Zoom prisijungimas pavyko!");
    }

    public function selectGroupPost(Request $request, $id) {

        $group = Group::find($id);
        if (!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

        if ($request->input("action") == "login") {
            $request->validate([
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                Auth::user()->createOrGetStripeCustomer();
                $intent = Auth::user()->createSetupIntent();

                return view("landing_other.group_order")->with("group", $group)->with("intent", $intent);
            }
            return view("landing_other.group_order")->with("group", $group)->with("message",
                "El. pašto adresas arba slaptažodis neteisingi");
        } elseif ($request->input("action") == "register") {
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'password' => 'required|string|confirmed|min:8',
                'email' => 'required|string|email|max:255|unique:users',
                'country' => 'required|string|max:255',
                'terms' => 'required',
            ]);

            $user = new User;
            $user->name = $request->input("name");
            $user->surname = $request->input("surname");
            $user->email = $request->input("email");
            $user->password = Hash::make($request->input("password"));
            $user->country = $request->input("country");
            $user->role = "user";
            $user->terms = $request->input("terms");
            $user->newsletter = $request->input("newsletter");

            if ($request->newsletter) {
                $mailchimpData = [
                    'email' => $request->email,
                    'status' => 'subscribed',
                    'firstname' => $request->input("name"),
                    'lastname' => $request->input("surname"),
                ];

                RegisteredUserController::syncMailchimp($mailchimpData);
            }

            $user->save();

            Auth::login($user);

            Auth::user()->createOrGetStripeCustomer();
            $intent = Auth::user()->createSetupIntent();

            return view("landing_other.group_order")->with("group", $group)->with("intent", $intent);
        } elseif ($request->input("action") == "order") {
            $request->validate([
                'students' => 'required',
                'payment_method' => 'required',
                'payment_type' => 'required',
            ]);

            Auth::user()->createOrGetStripeCustomer();
            $intent = Auth::user()->createSetupIntent(['payment_method_options' => ['card' => ['request_three_d_secure' => 'automatic']]]);

            if (!Auth::user()->hasDefaultPaymentMethod() && $group->adjustedPrice() > 0) {
                return view("landing_other.group_order")->with("group", $group)->with("intent",
                    $intent)->with("message", "Nerasti mokėjimo kortelės duomenys");
            }
            $json_students = json_decode($request->input("students"));
            $user = Auth::user();

            $date = new \DateTime;
            $date->modify('-2 minutes');
            $lastMins = $date->format('Y-m-d H:i:s');

            $lastPayments = Payment::where("user_id", $user->id)->where('created_at', '>=',
                $lastMins)->get()->toArray();
            if (count($lastPayments) > 0) { // prevent payment dublication
                if (end($lastPayments)['payment_status'] === 'requires_action') {
                    $errorMessage = 'Jūsų bankas naudoja 3D saugumo autorizaciją - prašome mokėjimą patvirtinti savo banke. Patvirtinus, gausite el.laišką su užsakymo patvirtinimu. Ačiū!';

                    return view("landing_other.group_order")->with("group", $group)->with("done_message",
                        $errorMessage);

                }
                return view("landing_other.group_order")->with("group", $group)->with("done_message",
                    "Ačiū, lauksime pamokose!");
            }

            $students = [];

            foreach ($json_students as $student_id) {
                if (Str::startsWith($student_id, "new_")) {
                    $student_info = explode("_", str_replace("new_", "", $student_id));
                    $student = new Student;
                    $student->name = $student_info[0];
                    $student->user_id = $user->id;
                    $student->group_id = -1;
                    $student->birthday = \Carbon\Carbon::parse($student_info[1]);
                    $student->save();
                    $students[] = $student;
                } else {
                    $student = Student::find($student_id);
                    if (!$student) {
                        return view("landing_other.group_order")->with("group", $group)->with("intent",
                            $intent)->with("message", "Klaida studentų pateikime");
                    }

                    if ($student->group_id != -1) {
                        $student = $student->replicate();
                        $student->group_id = -1;
                        $student->save();
                    }

                    $students[] = $student;
                }
            }

            if ($request->input("payment_type") == "subscription") {
                try {
                    $subscription = $user->newSubscription(
                        'main'.$user->stripe_plan_count, $group->stripe_plan
                    )->create($user->defaultPaymentMethod()->id);

                    $user->stripe_plan_count++;
                    $user->save();

                    $student_names = [];
                    $student_ids = [];

                    foreach ($students as $student) {
                        $student->group_id = $group->id;
                        $student->save();
                        $student_names[] = $student->name;
                        $student_ids[] = $student->id;

                    }

                    $subscription->students = json_encode($student_ids);
                    $subscription->save();

                    $email_title = "Kurso prenumerata";
                    $email_content = "<h1>Sveikiname prisijungus!</h1><p>Jūs sėkmingai užsiprenumeravote ".$group->name." kursą šiam(-iems) vaikui(-ams): ".join(" ",
                            $student_names).".<br><br>Prisijungti galite čia: <a href='".\Config::get('app.url')."/login'>".\Config::get('app.url')."/login</a></p>";

                    \Mail::send([], [], function ($message) use ($email_title, $email_content, $user) {
                        $message
                            ->to($user->email)
                            ->subject($email_title)
                            ->setBody($email_content, 'text/html');
                    });

                    $email_title_admin = "Kurso prenumerata";
                    $email_content_admin = "<h1>Kurso prenumerata</h1><p>Klientas ".$user->email." užsiprenumeravo ".$group->name." kursą šiam(-iems) vaikui(-ams): ".join(" ",
                            $student_names).".</p>";

                    \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin, $user) {
                        $message
                            ->to(\Config::get('app.email'))
                            ->subject($email_title_admin)
                            ->setBody($email_content_admin, 'text/html');
                    });
                } catch (Exception $e) {
                    return view("landing_other.group_order")->with("group", $group)->with("intent",
                        $intent)->with("done_message", "Užsakymo įvykdyti NEPAVYKO!");
                }
            }
            if ($request->input("payment_type") == "single") {

                $status = 0;
                if ($group->adjustedPrice() > 0) {
                    $price = $this->countPriceByStudentsAmount($students, $group->adjustedPrice());
                    try {
//                            $session['success_url'] = route('index').'/payments/checkout/?checkout=success';
//                            $session['cancel_url'] = route('index').'/payments/checkout/?checkout=canceled';
//                            var_dump($user->checkoutCharge($price * 100, $user->fullName(), count($students), $session));
//                            die();
                        $transaction = $user->charge($price * 100, $user->defaultPaymentMethod()->id,
                            ['payment_method_options' => ['card' => ['request_three_d_secure' => 'automatic']]]);
                        $status = $transaction->status;
//                           $transaction =  $user->charge(1000, 'pm_card_threeDSecure2Required');
                    } catch (IncompletePayment $exception) {
                        $transaction = $exception->payment;
                        $status = $transaction->status;
                        if ($status !== 'succeeded' && $status !== 'requires_action') {
                            return view("landing_other.group_order")->with("group", $group)->with("done_message",
                                "Užsakymo įvykdyti NEPAVYKO!");
                        }
                    }
                }


                $student_names = [];
                $student_ids = [];
                $student_birthDays = [];

                foreach ($students as $student) {
                    if ($status === 'succeeded') {
                        $student->group_id = $group->id;
                        $student->save();
                    }
                    $student_names[] = $student->name;
                    $student_ids[] = $student->id;
                    $student_birthDays[] = $student->birthday;
                }


                $payment = new Payment;
                $payment->user_id = $user->id;

                if ($group->adjustedPrice() > 0) {
                    $payment->amount = $transaction->amount;
                    $payment->payment_id = $transaction->id;
                } else {
                    $payment->amount = 0;
                    $payment->payment_id = 0;
                }


                if ($status === 'succeeded') {
                    $payment->payment_status = "paid";
                } else {
                    $payment->payment_status = $status;
                }


                $payment->group_id = $group->id;
                $payment->students = json_encode($student_ids);
                $payment->save();


                $messageArray = $this->getUserMessage($group, $status);
//                $user->email

                \Mail::send([], [], function ($message) use ($messageArray, $user) {
                    $message
                        ->to($user->email)
                        ->subject($messageArray['email_title'])
                        ->setBody($messageArray['email_content'], 'text/html');
                });


                if ($status === 'requires_action') {
                    $errorMessage = 'Jūsų bankas naudoja 3D saugumo autorizaciją - prašome mokėjimą patvirtinti savo banke. Patvirtinus, gausite el.laišką su užsakymo patvirtinimu. Ačiū!';
                    return view("landing_other.group_order")->with("group", $group)->with("done_message",
                        $errorMessage);

                }

                if ($status === 'succeeded') {
                    $teachers = $this->getTeachersWithLessons($group);
                    $email_title_admin = "Kurso užsakymas";
                    $email_content_admin = "<h1>Kurso užsakymas</h1><p> Klientas ".$user->name." ".$user->surname.
                        "<br> El. paštas: ".$user->email.
                        "<br>Grupė: ".$group->name.
                        "<br>Grupės ID: ".$group->id.
                        "<br>Grupės tipas: ".$group->type.
                        "<br>Pradžia: ".$group->start_date.
                        "<br>Mokytoja(-os): ".join(" ", $teachers).
                        " <br>Vaikas(-ai): ".join(" ", $student_names).
                        " <br>Amžius: ".join(" ", $student_birthDays).
                        ".</p>";

                    \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin, $user) {
                        $message
                            ->to(\Config::get('app.email'))
                            ->subject($email_title_admin)
                            ->setBody($email_content_admin, 'text/html');
                    });
                }
            }
            return view("landing_other.group_order")->with("group", $group)->with("done_message",
                "Ačiū, lauksime pamokose!");
        }
    }


    public function getUserMessage($group, $status) {

        if ($status === 'requires_action') {
            $email_title = "Apmokėjimas nepavyko!";
            $email_content = "<p>Sveiki,<br>".
                "džiaugiamės, kad renkatės Pasaką.<br> Jūsų bankas naudoja 3D saugumo autorizaciją - prašome mokėjimą patvirtinti savo banke. Patvirtinus, gausite el.laišką su kurso užsakymo patvirtinimu. Ačiū!<br> Kilus klausimams ar neaiškumams rašykite labas@mokyklelepasaka.com</p>";

            return [
                'email_title' => $email_title,
                'email_content' => $email_content,
            ];
        }

        $email_title = "Registracijos patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "džiaugiamės, kad prisijungsite prie Pasakos pamokų!<br>".
            "Jūsų detalės apačioje:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone(\Cookie::get("user_timezone",
                "Europe/London"))->format("H:i")."<br>".
            "Kursas vyks  ".\Carbon\Carbon::parse($group->start_date)->format("m.d")." - ".\Carbon\Carbon::parse($group->start_date)->format("m.d")." (".$group->course_length." sav.<br>".
            "Savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyroje</a> patogiai prisijungsite į pamokas, rasite namų darbus ir galėsite bendrauti su kitais nariais. </p>".
            "<p>Iki pasimatymo,<br> Pasakos komanda </p>";

        if ($group->adjustedPrice() == 0) {
            $email_title = "Registracijos į nemokamą pamoką patvirtinimas";
            $email_content = "<p>Sveiki,<br>".
                "ačiū, kad registravotės į nemokamą Pasakos pamoką! Jūsų nemokamos pamokos detalės čia:<br>".
                $group->name."<br>".
                $group->display_name." ".$group->time->timezone(\Cookie::get("user_timezone",
                    "Europe/London"))->format("H:i")."<br>".
                "Į pamoką prisijungsite iš savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyros</a>.</p>".
                "<p>Grupes tolimesniam mokymuisi skirstome ne tik pagal amžių, bet ir pagal kalbos mokėjimo lygį - taip galime užtikrinti, kad vaikai pasieks geriausių rezultatų ir drąsiau jausis pamokoje.<br>".
                "Nemokamos pamokos metu mokytoja įvertins vaiko kalbos mokėjimo lygį ir vėliau mes pasiūlysime tinkamiausią grupę jūsų vaikui.<br>".
                "<small>Jei negalėsite dalyvauti pamokoje, labai prašome iš anksto pranešti - vietų skaičius ribotas, o norinčiųjų daug!</small></p>".
                "<p>Iki pasimatymo,<br> Pasakos komanda </p>";
        }

        return [
            'email_title' => $email_title,
            'email_content' => $email_content,
        ];
    }


    private function getTeachersWithLessons($group) {
        if (empty($group->events())) {
            return [];

        }
        $lessons = $group->events()->where("date_at", ">", \Carbon\Carbon::now('utc'))->orderBy("date_at",
            "ASC")->get();
        $teachers = [];
        foreach ($lessons as $lesson) {
            $teacher = $lesson->teacher()->first()->toArray();
            if (!isset($teachers[$teacher['id']])) {
                $teachers[$teacher['id']] = $teacher['name'].' '.$teacher['surname'];
            }
        }
        return $teachers;
    }

    private function countPriceByStudentsAmount($students, $price): float {
        $numberOfStudents = count($students);
        if ($numberOfStudents === 1) {
            return $price;
        }

        if ($numberOfStudents > 1) {
            $numberOfStudentsWithDiscount = $numberOfStudents - 1;
            $discountedPrice = $price / 2;
            $newPrice = $price + ($numberOfStudentsWithDiscount * $discountedPrice);
            return $newPrice;
        }
    }

    public function customRoute(Request $request, $page) {
        if (\View::exists("landing.".str_replace("-", "_", $page))) {
            return view("landing.".str_replace("-", "_", $page));
        }
        return view("landing_other.error")->with("error", "404 - puslapis nerastas.");
    }


}
