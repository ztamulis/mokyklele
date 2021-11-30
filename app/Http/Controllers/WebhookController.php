<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Student;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
//    public function handlePaymentIntentSucceeded($payload)
//    {
//        // Handle the incoming event...
//
//        Log::info('handlePaymentIntentSucceeded');
//        $data = $payload['data'];
//
//        Log::info($data->id);
//        Log::info($data->object);
//        Log::info($data->amount_captured);
//        Log::info($data->paid);
//        Log::info($data->payment_intent);
//
//        $payment = Payment::where('payment_id', $payload->id)->first();
//        if ($payload->status === 'succeeded' && $payment->status !== 'paid') {
//            Log::info($payment->students);
//            $payment->status = 'paid';
//            $payment->save();
////            Student::whereIn('id', $payment->students)->update(['group_id', $payment->group_id]);
//
//            Log::info($payment);
//
//        }
//
//        Log::info($payload);
//
//        echo $payload;
//    }

    /**
     * @param $payload
     */
//    public function handleInvoicePaymentSucceeded($payload)
//    {
//        // Handle the incoming event...
//
//        Log::info('handleInvoicePaymentSucceeded');
//        Log::info($payload->status);
//        Log::info($payload->id);
//        $payment = Payment::where('payment_id', $payload->id)->first();
//        if ($payload->status === 'succeeded' && $payment->status !== 'paid') {
//            Log::info($payment->students);
//            $payment->status = 'paid';
//            $payment->save();
////            Student::whereIn('id', $payment->students)->update(['group_id', $payment->group_id]);
//
//            Log::info($payment);
//
//        }
//        Log::info($payload);
//
//
//        echo $payload;
//    }


    public function handleCheckoutSessionCompleted($payload) {
        $data = $payload['data']['object'];

        $payment = Payment::where('payment_id', $data['payment_intent'])->first();
        if ($payment->payment_status !== 'paid') {
            $studentsIds = json_decode($payment->students);
            $students = Student::whereIn('id', $studentsIds)->get();
            $group = $payment->group()->first();
            $user = $payment->user()->first();
            foreach ($students as $student){
                $student->group_id = $group->id;
                $student->save();
                $student_names[] = $student->name;
                $student_ids[] = $student->id;
                $student_birthDays[] = $student->birthday;
            }

            if (!empty($payment->discount_code)) {
                $this->registerUserCoupon($payment);
            }
            $payment->payment_status = 'paid';
            $payment->save();
//            Student::whereIn('id', $studentsIds)->update(['group_id' => $payment->group_id]);

        } else {
            return;
        }

        $messageArray = $this->getCheckoutSessionSucceededUserMessage($group, $user);

        \Mail::send([], [], function ($message) use ($messageArray, $user) {
            $message
                ->to($user->email)
                ->subject($messageArray['email_title'])
                ->setBody($messageArray['email_content'], 'text/html');
        });


        $teachers = $this->getTeachersWithLessons($group);
        $email_title_admin = "Kurso užsakymas";
        $time = $group->time->timezone('Europe/London')->format("H:i");
        if ($group->paid) {
            $paid = 'Taip';
        } else {
            $paid = 'Ne';
        }

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
            "<br>Skirta: ".Group::$FOR_TRANSLATE[$group->age_category] .
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

    private function registerUserCoupon($payment) {
        $coupon = Coupon::where('code', $payment->discount_code)->first();

        if (!empty($coupon)) {
            $userCoupon = new UserCoupon();
            $userCoupon->user_id = $payment->user_id;
            $userCoupon->coupon_id = $coupon->id;
            $userCoupon->redeemed_at = Carbon::now()->timestamp;
        }
    }

    /**
     * @param $payload
     */
    public function handleChargeSucceeded($payload) {
        $data = $payload['data']['object'];
        $payment = Payment::where('payment_id', $data['payment_intent'])->first();
        if ($payment->payment_status !== 'paid') {
            $studentsIds = json_decode($payment->students);
            $students = Student::whereIn('id', $studentsIds)->get();
            $group = $payment->group()->first();
            $user = $payment->user()->first();
            foreach ($students as $student){
                $student->group_id = $group->id;
                $student->save();
                $student_names[] = $student->name;
                $student_ids[] = $student->id;
                $student_birthDays[] = $student->birthday;
            }

            $payment->payment_status = 'paid';

            if (!empty($payment->discount_code)) {
                $this->registerUserCoupon($payment);
            }

            $payment->save();
//            Student::whereIn('id', $studentsIds)->update(['group_id' => $payment->group_id]);

        } else {
            return;
        }

        $messageArray = $this->getCheckoutSessionSucceededUserMessage($group, $user);

        \Mail::send([], [], function ($message) use ($messageArray, $user) {
            $message
                ->to($user->email)
                ->subject($messageArray['email_title'])
                ->setBody($messageArray['email_content'], 'text/html');
        });

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
            "<br>Skirta: ".Group::$FOR_TRANSLATE[$group->age_category] .
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

    private function getCheckoutSessionSucceededUserMessage($group, $user) {
        $timezone = \Cookie::get("user_timezone", "GMT");
        if (!empty($user->time_zone)) {
            $timezone = $user->time_zone;
        }


        $groupData = $group->getGroupStartDateAndCount();
        if (isset($groupData['startDate'])) {
            $startDate = \Carbon\Carbon::parse($groupData['startDate'])->format("m.d");
        } else {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $group->start_date)->format("m.d");
        }

        $email_title = "Registracijos patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "džiaugiamės, kad prisijungsite prie Pasakos pamokų!<br>".
            "Jūsų detalės apačioje:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone($timezone)->format("H:i")." (".$timezone.")<br>".
            "Kursas vyks  ". $startDate." - ". \Carbon\Carbon::parse($group->end_date)->format("m.d")." (".$group->course_length." sav.)<br>".
            "Savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyroje</a> patogiai prisijungsite į pamokas, rasite namų darbus ir galėsite bendrauti su kitais nariais. </p>".
            "<p>Iki pasimatymo,<br> Pasakos komanda </p>";

        return [
            'email_title' => $email_title,
            'email_content' => $email_content,
        ];
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

    /**
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function handleCustomerSubscriptionCreated($payload)
    {
        // Handle the incoming event...
        $payment = Payment::where('payment_id', $payload->id)->first();
        if ($payload->status === 'succeeded' && $payment->status !== 'paid') {
            $payment->status = 'paid';
            $payment->save();
//            Student::whereIn('id', $payment->students)->update(['group_id', $payment->group_id]);


        }


        echo $payload;
    }

}