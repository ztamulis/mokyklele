<?php


namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Cashier\Exceptions\IncompletePayment;

class OrderController extends Controller {


    public function selectFreeOrder($id) {
        $group = Group::find($id);
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

        return view("lessons_order.group_create_free_order")->with("group", $group);
    }

    public function selectGroupOrder(Request $request, $id) {
        $group = Group::find($id);
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        $coupon = $request->input('coupon');
        if (isset($coupon)) {
            $coupon = Coupon::where('code', $coupon)->first();

            if (empty($coupon)) {
                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kuponas nerastas");
            }
            if (!empty($coupon->expires_at)
                && Carbon::createFromDate($coupon->expires_at)->timestamp < Carbon::now()->timestamp) {
                $coupon = [];
                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kupono galiojimas pasibaigė");
            }

            if ($coupon->userCoupons->where('user_id', Auth::user()->id)->count() >= 2) {
                $coupon = [];

                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kupono limitas vartotojui išnaudotas");
            }
        }
        return view("lessons_order.group_create_order")->with("group", $group)->with('coupon', $coupon);
    }

    public function showSuccessPage($id) {
        $group = Group::find($id);
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

        return view("lessons_order.group_free_order_succeeded")
            ->with("group", $group)
            ->with("message", "Ačiū, lauksime pamokoje!");
    }

    public function createFreeOrder(Request $request, $id) {
        $group = Group::find($id);
        $user = Auth::user();
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        $json_students = json_decode($request->input("students"));
        $students = [];
        $dublicatedUsers = [];
        foreach ($json_students as $student_id) {
            if(Str::startsWith($student_id, "new_")){
                $student_info = explode("_", str_replace("new_", "", $student_id));
                $studentCheck = Student::where('name', $student_info)->where('user_id', $user->id)
                    ->where('group_id', $group->id)
                    ->first();
                if (!empty($studentCheck)) {
                    $dublicatedUsers[] = $student_info[0];
                    continue;
                }
                $student = new Student;
                $student->name = $student_info[0];
                $student->user_id = $user->id;
                $student->group_id = -1;
                $student->birthday = \Carbon\Carbon::parse($student_info[1]);
                $student->save();
                $students[] = $student;
            }else{
                $student = Student::find($student_id);
                if(!$student) {
                    return view("lessons_order.group_create_free_order")
                        ->with("group", $group)
                        ->with("error", "Klaida studentų pateikime");
                }
                $studentCheck = Student::where('name', $student->name)->where('user_id', $user->id)
                    ->where('group_id', $group->id)
                    ->first();

                if (!empty($studentCheck)) {
                    $dublicatedUsers[] = $student->name;
                    continue;
                }


                if($student->group_id != -1) {
                    $student = $student->replicate();
                    $student->group_id = -1;
                    $student->save();
                }

                $students[] = $student;
            }
        }
        if (!empty($dublicatedUsers)) {
            return view("lessons_order.group_create_free_order")
                ->with("group", $group)
                ->with("error", join(", ", $dublicatedUsers)." jau priskirti grupei");
        }

        $student_names = [];
        $student_ids = [];
        $student_birthDays = [];

        foreach ($students as $student){
            $student->group_id = $group->id;
            $student->save();
            $student_names[] = $student->name;
            $student_ids[] = $student->id;
            $student_birthDays[] = $student->birthday->format('Y-m-d');
        }


        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->amount = 0;
        $payment->payment_id = 0;
        $payment->payment_status = 'free_lesson';


        $payment->group_id = $group->id;
        $payment->students = json_encode($student_ids);
        $payment->save();

        $user->time_zone = Cookie::get("user_timezone", "GMT");
        $user->save();

        $messageArray = $this->getRegisterFreeUserMessage($group, $user);

        \Mail::send([], [], function ($message) use ($messageArray, $user) {
            $message
                ->to($user->email)
                ->subject($messageArray['email_title'])
                ->setBody($messageArray['email_content'], 'text/html');
        });

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);
        return redirect()->route('orderFreeSuccess', ['id' => $group->id])->withInput();
    }




    public function checkoutResponse(Request $request) {
        $user = Auth::user();

        $payment = Payment::where('session_id', $request->input('session_id'))
            ->where('user_id', $user->id)
            ->first();

        if (empty($payment)) {
            return view("lessons_order.group_order_succeeded")->with("error", 1)->with("message", "Užsakymas nerastas.");
        }

        $group = $payment->group()->first();

        if (!empty($request->input('payment'))) {
            $payment->payment_status = 'canceled';
            $payment->save();
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Užsakymas nutrauktas.");

        }

        if ($payment->payment_status !== 'paid') {
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Ačiū, lauksime pamokose!");
        } else {
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Užsakymas jau įvykdytas!");
        }

    }



    public function createOrderCheckout(Request $request, $id) {
        $group = Group::find($id);
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        $json_students = json_decode($request->input("students"));
        $students = [];
        $user= Auth::user();
        $dublicatedUsers = [];
        foreach ($json_students as $student_id) {
            if(Str::startsWith($student_id, "new_")){
                $student_info = explode("_", str_replace("new_", "", $student_id));
                $studentCheck = Student::where('name', $student_info)->where('user_id', $user->id)
                    ->where('group_id', $group->id)
                    ->first();

                if (!empty($studentCheck)) {
                    $dublicatedUsers[] = $student_info[0];
                    continue;
                }

                $student = new Student;
                $student->name = $student_info[0];
                $student->user_id = $user->id;
                $student->group_id = -1;
                $student->birthday = \Carbon\Carbon::parse($student_info[1]);
                if (empty($student->birthday)) {
                    return view("lessons_order.group_create_free_order")
                        ->with("group", $group)
                        ->with("error", "Neparinktas mokinio gimtadienis");
                }
                $student->save();
                $students[] = $student;
            }else{
                $student = Student::find($student_id);
                if(!$student) {
                    return view("lessons_order.group_create_free_order")
                        ->with("group", $group)
                        ->with("error", "Klaida studentų pateikime");
                }
                $studentCheck = Student::where('name', $student->name)->where('user_id', $user->id)
                    ->where('group_id', $group->id)
                    ->first();
                if (!empty($studentCheck)) {
                    $dublicatedUsers[] = $student->name;
                    continue;
                }


                if($student->group_id != -1) {
                    $student = $student->replicate();
                    $student->group_id = -1;
                    $student->save();
                }

                $students[] = $student;
            }
        }

        if (!empty($dublicatedUsers)) {
            return view("lessons_order.group_create_order")
                ->with("group", $group)
                ->with("error", join(", ", $dublicatedUsers)." jau priskirti grupei");
        }

        $price = $this->countPriceByStudentsAmount($students, $group->adjustedPrice());
        $coupon = Coupon::where('code', $request->input('coupon-code'))->first();
        $price = $this->applyCoupon($price, $coupon);
        try {
            $session['success_url'] = route('index').'/payments/checkout/response?session_id={CHECKOUT_SESSION_ID}';
            $session['cancel_url'] = route('index').'/payments/checkout/response?payment=cnl&session_id={CHECKOUT_SESSION_ID}';
            $transaction = $user->checkoutCharge($price * 100, $user->fullName(), 1, $session);

        } catch (IncompletePayment $exception) {
            $transaction = $exception->payment;
            if ($exception->payment->status !== 'succeeded') {
                return view("landing_other.group_order")->with("group", $group)->with("error", "Užsakymo įvykdyti NEPAVYKO!");
            }
        }
        $student_ids = [];

        foreach ($students as $student){
            $student_ids[] = $student->id;
        }

        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->amount = $transaction->amount_total;
        $payment->payment_id = $transaction->payment_intent;
        $payment->payment_status = 'checkoutStarted';
        if (!empty($coupon)) {
            $payment->discount_code = $coupon->code;
            $payment->discount_amount = $coupon->discount;
        }
        $payment->group_id = $group->id;
        $payment->students = json_encode($student_ids);
        $payment->url = $transaction->url;
        $payment->session_id = $transaction->id;
        $payment->save();

        $user->time_zone = Cookie::get("user_timezone", "GMT");
        $user->save();

        return Redirect::to('/select-group/order/'.$group->id.'/confirm')->with('paymentInfo', $payment)->with('checkoutUrl', $transaction->url);
    }

    private function applyCoupon($price, $coupon) {
        if (empty($coupon)) {
            return $price;
        }

        if (
            empty($coupon)
            ||  ((!empty($coupon->expires_at) && Carbon::createFromDate($coupon->expires_at)->timestamp < Carbon::now()->timestamp))
            || $coupon->userCoupons->where('user_id', Auth::user()->id)->count() >= 2) {
            return $price;
        }

        if ($coupon->type === 'fixed') {
            return $price - $coupon->discount;
        }

        if ($coupon->type === 'percent') {
            return $price - ($price * $coupon->discount / 100);
        }
    }

    private function sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user) {
        $teachers = $this->getTeachersWithLessons($group);
        $email_title_admin = "Kurso užsakymas";
        $paid = $group->paid ? 'Taip' : 'Ne';


        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        $time = $group->time->timezone('Europe/London')->format("H:i");

        $email_content_admin = "<h1>Kurso užsakymas</h1><p> Klientas ".  $user->name. " " .$user->surname .
            "<br> El. paštas: ".$user->email.
            "<br>Grupė: ".$group->name .
            "<br>Grupės ID: ".$group->id .
            "<br>Grupės tipas: ".$group->type .
            "<br>Mokama: ".$paid .
            "<br>Laikas: ".$time .
            "<br>Pradžia: ".$startDate .
            "<br>Mokytoja(-os): ".join(" ", $teachers).
            " <br>Vaikas(-ai): ".join(" ", $student_names).
            " <br>Amžius: ".join(" ", $student_birthDays).
            ".</p>";
//        env("ADMIN_EMAIL")
        \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin, $user) {
            $message
                ->to(env("ADMIN_EMAIL"))
                ->subject($email_title_admin)
                ->setBody($email_content_admin, 'text/html');
        });
    }


    public function orderConfirmation(Request $request, $id) {
        $user = Auth::user();
        $payment = session()->get( 'paymentInfo');
        if (empty($payment)) {
            $payment = Payment::where('user_id', $user->id)->latest()->first();
        }


        $students = Student::whereIn('id', json_decode($payment->students))->get();
        foreach ($students as $student){
            $student_names[] = $student->name;
        }

        $group = $payment->group()->first();
        $studentsName = join("; ", $student_names);
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->end_date)->format('Y-m-d');
        $data = [
            'students' => $studentsName,
            'full_name' => $user->fullName(),
            'group_name' => $group->name,
            'group_starts' => $startDate,
            'group_ends' => $endDate,
            'time' => $group->time,
            'price' => $payment->amount / 100,
            'url' => $payment->url,

        ];
        return view("lessons_order.group_confirm_order")->with('paymentInfo', $data);
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

    private function getTeachersWithLessons($group) {
        if (empty($group->events())) {
            return [];

        }
        $lessons = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc'))->orderBy("date_at","ASC")->get();
        $teachers = [];
        foreach ($lessons as $lesson) {
            $teacher = $lesson->teacher()->first()->toArray();
            if (!isset($teachers[$teacher['id']])) {
                $teachers[$teacher['id']] = $teacher['name'] . ' ' . $teacher['surname'];
            }
        }
        return $teachers;
    }



    private function getRegisterFreeUserMessage($group, $user) {

        $timezone = \Cookie::get("user_timezone", "GMT");
        if (!empty($user->time_zone)) {
            $timezone = $user->time_zone;
        }


        $email_title = "Registracijos į nemokamą pamoką patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "ačiū, kad registravotės į nemokamą Pasakos pamoką! Jūsų nemokamos pamokos detalės čia:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone($timezone)->format("H:i")." (".$timezone.")<br>".
            "Į pamoką prisijungsite iš savo <a href='".env("APP_URL")."/login'>Pasakos paskyros</a>.</p>".
            "<p>Grupes tolimesniam mokymuisi skirstome ne tik pagal amžių, bet ir pagal kalbos mokėjimo lygį - taip galime užtikrinti, kad vaikai pasieks geriausių rezultatų ir drąsiau jausis pamokoje.<br>".
            "Nemokamos pamokos metu mokytoja įvertins vaiko kalbos mokėjimo lygį ir vėliau mes pasiūlysime tinkamiausią grupę jūsų vaikui.<br>".
            "<small>Jei negalėsite dalyvauti pamokoje, labai prašome iš anksto pranešti - vietų skaičius ribotas, o norinčiųjų daug!</small></p>".
            "<p>Iki pasimatymo,<br> Pasakos komanda </p>";

        return [
            'email_title' => $email_title,
            'email_content' => $email_content,
        ];
    }


}