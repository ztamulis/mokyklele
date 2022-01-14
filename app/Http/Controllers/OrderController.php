<?php


namespace App\Http\Controllers;

use App\Http\Traits\CheckoutEmailsTrait;
use App\Http\Traits\NotificationsTrait;
use App\Models\Coupon;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Student;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Cashier\Exceptions\IncompletePayment;

class OrderController extends Controller {
    use NotificationsTrait;
    use CheckoutEmailsTrait;

    public function selectFreeOrder($slug) {

        $group = Group::where('slug', $slug)->first();
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        if ($group->students()->count() >=  $group->slots) {
            return view("landing_other.error")->with("error", "Grupė pilna.");
        }

        return view("lessons_order.group_create_free_order")->with("group", $group);
    }

    public function selectGroupOrder(Request $request, $slug) {
        $group = Group::where('slug', $slug)->first();

        if ($group->slots <= $group->students()->count()) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė pilna.");
        }

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
                    ->with("error", "Kuponas nerastas!");
            }
            if (!empty($coupon->expires_at)
                && Carbon::createFromDate($coupon->expires_at)->timestamp < Carbon::now()->timestamp
            || !$coupon->active) {
                $coupon = [];
                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kupono galiojimas pasibaigė!");
            }

            if ($coupon->userCoupons->where('user_id', Auth::user()->id)->count() >= 2) {
                $coupon = [];

                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kupono limitas vartotojui išnaudotas!");
            }

            if ($coupon->use_limit <= $coupon->used) {
                $coupon = [];

                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kupono limitas išnaudotas!");
            }
            if (!empty($coupon->groups) && !isset(array_flip($coupon->groups)[$group->id])) {
                $coupon = [];

                return view("lessons_order.group_create_order")
                    ->with("group", $group)
                    ->with('coupon', $coupon)
                    ->with("couponError", 1)
                    ->with("error", "Kuponas netinka šiai grupei!");
            }
        }
        return view("lessons_order.group_create_order")->with("group", $group)->with('coupon', $coupon);
    }

    public function showSuccessPage($slug) {
        $group = Group::where('slug', $slug)->first();
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }

        return view("lessons_order.group_free_order_succeeded")
            ->with("group", $group)
            ->with("message", "Ačiū, lauksime pamokoje!");
    }

    public function createFreeOrder(Request $request, $slug) {
        $group = Group::where('slug', $slug)->first();

        $user = Auth::user();
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        $json_students = json_decode($request->input("students"));
        $students = [];
        $dublicatedUsers = [];

        $groupCount = $group->students()->count();
        $groupNewCount = $groupCount + count($json_students);
        if ($groupNewCount > $group->slots) {
            return view("lessons_order.group_create_free_order")
                ->with("group", $group)
                ->with("error",  $this->getFullGroupErrorText($groupCount, $group->slots));
        }
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
            } else{
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
            if(!empty($student->birthday)) {

                $student_birthDays[] = $student->birthday->format('Y-m-d');
            }
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
        $date = Carbon::parse($group->start_date)->setTimezone(Cookie::get("user_timezone", "GMT"));
        $now = Carbon::now()->setTimezone(Cookie::get("user_timezone", "GMT"));

        $diff = $date->diffInDays($now);
        //find a better solution;
        if ($diff > 0) {
            $this->insertUserNotification($user, $group);
        }


        $messageArray = $this->getRegisterFreeUserMessage($group, $user);

        \Mail::send([], [], function ($message) use ($messageArray, $user) {
            $message
                ->to($user->email)
                ->subject($messageArray['email_title'])
                ->setBody($messageArray['email_content'], 'text/html');
        });

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);
        return redirect()->route('orderFreeSuccess', ['slug' => $group->slug])->withInput();
    }

    private function getFullGroupErrorText($groupCount, $slots) {
        $freeSlots = $slots - $groupCount;
        $text = '';
        if ($freeSlots == 1) {
            $text = 'Grupėje laisva tik '.$freeSlots. ' vieta';
        }
        if ($freeSlots > 1) {
            $text = 'Grupėje laisvos tik '.$freeSlots. ' vietos';

        }
        if ($freeSlots == 0) {
            $text = 'Grupė pilna';

        }
        return $text;
    }




    public function createOrderCheckout(Request $request, $slug) {
        $group = Group::where('slug', $slug)->first();
        if(!$group) {
            return view("landing_other.error")->with("error", "Pasirinkta grupė nerasta.");
        }
        $json_students = json_decode($request->input("students"));
        $students = [];
        $user= Auth::user();
        $dublicatedUsers = [];
        $coupon = Coupon::where('code', $request->input('coupon-code'))->first();

        $groupCount = $group->students()->count();

        $groupNewCount = $groupCount + count($json_students);
        if ($groupNewCount > $group->slots) {
            return view("lessons_order.group_create_order")
                ->with("group", $group)
                ->with("error",  $this->getFullGroupErrorText($groupCount, $group->slots));
        }



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
                    return view("lessons_order.group_create_order")
                        ->with("group", $group)
                        ->with("coupon", $coupon)
                        ->with("error", "Neparinktas mokinio gimtadienis");
                }
                $student->save();
                $students[] = $student;
            }else{
                $student = Student::find($student_id);
                if(!$student) {
                    return view("lessons_order.group_create_order")
                        ->with("group", $group)
                        ->with("coupon", $coupon)
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
                ->with("coupon", $coupon)
                ->with("error", join(", ", $dublicatedUsers)." jau priskirti grupei");
        }


        $originalPrice = $this->countPriceByStudentsAmount($students, $group->adjustedPrice());
        $price = $this->applyCoupon($originalPrice, $coupon);
        if (!empty($price)) {
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
        }

        $student_ids = [];

        foreach ($students as $student){
            $student_ids[] = $student->id;
        }

        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->payment_status = 'checkoutStarted';
        if (!empty($coupon)) {
            $payment->discount_code = $coupon->code;
            $payment->discount_amount = $originalPrice - $price;
        }
        $payment->group_id = $group->id;
        $payment->students = json_encode($student_ids);
        if (!empty($price)) {
            $payment->amount = $transaction->amount_total;
            $payment->url = $transaction->url;
            $payment->session_id = $transaction->id;
            $payment->payment_id = $transaction->payment_intent;
        } else {
            $payment->amount = $price * 100;
            $code = $this->getFreeTransactionCode();
            $payment->url = route('index').'/payments/checkout/response?session_id='.$code;
            $payment->session_id = $code;
            $payment->payment_id = 0;

        }
        $payment->save();

        $user->time_zone = Cookie::get("user_timezone", "GMT");
        $user->save();

        return Redirect::to('/select-group/order/'.$group->slug.'/confirm')->with('paymentInfo', $payment)->with('checkoutUrl', $payment->url);
    }

    private function getFreeTransactionCode() {
        $code = md5(substr(md5(uniqid(mt_rand(), true)) , 0, 8));
        $code = 'free_'.$code;
        if (empty(Payment::where('session_id', $code)->first())) {
            return $code;
        } else {
            $this->getFreeTransactionCode();
        }
    }


    private function applyCoupon($price, $coupon) {
        if (empty($coupon)) {
            return $price;
        }

        if (
            empty($coupon)
            ||  ((!empty($coupon->expires_at) && Carbon::createFromDate($coupon->expires_at)->timestamp < Carbon::now()->timestamp))
            || $coupon->use_limit <= $coupon->used
            || $coupon->userCoupons->where('user_id', Auth::user()->id)->count() >= 2
            || (!empty($coupon->groups) && !isset(array_flip($coupon->groups)[$group->id]))
            || !$coupon->active
        ) {
            return $price;
        }

        if ($coupon->type === 'fixed') {
            return $price - $coupon->discount;
        }

        if ($coupon->type === 'percent') {
            return $price - ($price * $coupon->discount / 100);
        }
    }

    public function checkoutResponse(Request $request) {
        $user = Auth::user();
//        if ($request->input('session_id'))
        $payment = Payment::where('session_id', $request->input('session_id'))
            ->where('user_id', $user->id)
            ->first();

        if (empty($payment) || $payment->user_id !== Auth::user()->id) {
            return view("lessons_order.group_order_succeeded")->with("error", 1)->with("message", "Užsakymas nerastas.");
        }
        $group = $payment->group()->first();
        if ($payment->payment_status === 'paid' || $payment->payment_status === 'free_lesson') {
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Ačiū, lauksime pamokose!");

        }
        if (empty($payment->payment_id)) {
            $this->checkoutResponseZeroValue($payment, $group, $user);
        }


        if (!empty($request->input('payment'))) {
            $payment->payment_status = 'canceled';
            $payment->save();
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Užsakymas nutrauktas.");

        }
        if ($payment->payment_status == 'paid' || $payment->payment_status == 'free_lesson') {
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Ačiū, lauksime pamokose!");
        } else {
            return view("lessons_order.group_order_succeeded")->with("group", $group)->with("message", "Užsakymas jau įvykdytas!");
        }

    }


    private function checkoutResponseZeroValue($payment, $group, $user) {
        $students = Student::whereIn('id', json_decode($payment->students))->get();
        foreach ($students as $student){
            $student->group_id = $group->id;
            $student->save();
            $student_names[] = $student->name;
            $student_ids[] = $student->id;
            if(!empty($student->birthday)) {
                $student_birthDays[] = $student->birthday->format('Y-m-d');
            }
        }
        $date = Carbon::parse($group->start_date)->setTimezone($user->time_zone);
        $now = Carbon::now()->setTimezone($user->time_zone);

        $diff = $date->diffInDays($now);
        //find a better solution;
        if ($diff > 0) {
            $this->insertUserNotification($user, $group);
        }

        if (!empty($payment->discount_code)) {
            $this->registerUserCoupon($payment);
        }

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);
        $this->sendCheckoutSessionSucceededUserMessage($group, $user);
        $payment->payment_status = 'free_lesson';
        $payment->save();
    }

    private function registerUserCoupon($payment) {
        $coupon = Coupon::where('code', $payment->discount_code)->first();

        if (!empty($coupon)) {
            $userCoupon = new UserCoupon();
            $userCoupon->user_id = $payment->user_id;
            $userCoupon->coupon_id = $coupon->id;
            $userCoupon->save();
            $coupon->used = $coupon->used + 1;
            $coupon->save();
        }
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
        $groupData = $group->getGroupStartDateAndCount();
        if (isset($groupData['startDate'])) {
            $startDate = \Carbon\Carbon::parse($groupData['startDate'])->format('Y-m-d');
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        }
        if (isset($group->end_date)) {
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->end_date)->format('Y-m-d');
        } else {
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        }

        $data = [
            'students' => $studentsName,
            'full_name' => $user->fullName(),
            'group_name' => $group->name,
            'group_starts' => $startDate,
            'group_ends' => $endDate,
            'time' => $group->time,
            'price' => $payment->amount / 100,
            'url' => $payment->url,
            'session_id' => $payment->session_id,
            'age_category' => $group->age_category,

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




    public function sendPaymentEmail($paymentId) {
        $payment = Payment::where('payment_id', $paymentId)->first();
        if ($payment->payment_status === 'paid') {
            $studentsIds = json_decode($payment->students);
            $students = Student::whereIn('id', $studentsIds)->get();
            $group = $payment->group()->first();
            $user = $payment->user()->first();
            foreach ($students as $student){
                $student_names[] = $student->name;
                $student_ids[] = $student->id;
                $student_birthDays[] = $student->birthday;
            }


        } else {
            return;
        }

//        $messageArray = $this->getCheckoutSessionSucceededUserMessage($group, $user);
//        \Mail::send([], [], function ($message) use ($messageArray, $user) {
//            $message
//                ->to($user->email)
//                ->subject($messageArray['email_title'])
//                ->setBody($messageArray['email_content'], 'text/html');
//        });

        $teachers = $this->getTeachersWithLessons($group);
        $email_title_admin = "Kurso užsakymas";
        if ($group->paid) {
            $paid = 'Taip';
        } else {
            $paid = 'Ne';
        }
        $time = $group->time->timezone('Europe/London')->format("H:i");


        $groupData = $group->getGroupStartDateAndCount();
        if (isset($groupData['startDate'])) {
            $startDate = \Carbon\Carbon::parse($groupData['startDate'])->format('Y-m-d');
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format('Y-m-d');
        }

        $email_content_admin = "<h1>Kurso užsakymas</h1><p> Klientas ".  $user->name. " " .$user->surname .
            "<br> El. paštas: ".$user->email.
            "<br>Grupė: ".$group->name .
            "<br>Grupės ID: ".$group->id .
            "<br>Grupės tipas: ".$group->type .
            "<br>Mokama: ".$paid .
            "<br>laikas: ".$time .
            "<br>Pradžia: ".$startDate .
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