<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Meeting;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Reward;
use App\Models\Student;
use App\Models\Group;
use App\Models\UserCoupon;
use App\TimeZoneUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CronjobController extends Controller {

    public function main(Request $request) {
        echo "Automatic attendance set started<br>";
        foreach (Event::where("attendance_auto_set", 0)->where("date_at", "<", \Carbon\Carbon::now()->subMinutes(10))->get() as $event) { // automatic attendance set
            $students = [];
            foreach ($event->groups as $group) {
                foreach ($group->students as $student){
                    $attendance = new Attendance;
                    $attendance->student_id = $student->id;
                    $attendance->event_id = $event->id;
                    $attendance->save();
                    echo "Set " . $student->name . " attended in " . $event->name . "<br>";
                }
            }

            $event->attendance_auto_set = 1;
            $event->save();

            echo "Event " . $event->name . " updated.<br><br>";
        }
        echo "Automatic attendance set ended<br>";

        echo "Automatic reward set started<br>";
        foreach (Student::all() as $student){
            if(!$student->user)
                continue;
            $attendanceCount = $student->attendances->count();
            foreach (Reward::where("attendance_to_get_reward", "<=", $attendanceCount)->where("attendance_to_get_reward", ">", -1)->get() as $reward) {
                if(!$student->user->rewards->contains($reward->id)){
                    $student->user->rewards()->attach($reward->id);
                    echo "Given ".$reward->name." reward to " . $student->user->email . " ($attendanceCount >= ".$reward->attendance_to_get_reward.")<br>";
                }
            }
        }
        echo "Automatic reward set ended<br>";

        echo "Automatic notification email sending started<br>";
        foreach (Message::where("email_sent", 0)->where("seen",0)->get() as $message) {

            if(!$message->author) {
                continue;
            }

            $email_title = "Gavote ??inut??";
            $email_content = "<p>Sveiki,<br>gavote ??inut?? Pasakos paskyroje nuo ".($message->author->role == "admin" ? "Pasakos" :  $message->author->name." ". $message->author->surname).
            "<br>Prane??im?? galite per??i??r??ti ??ia: <a href='".\Config::get('app.url')."/dashboard/messages/".$message->id."'>".\Config::get('app.url')."/dashboard/messages/".$message->id."</a>";
            if (!empty($message->message)) {
                $email_content .= "<br>??inut??: <p>" . strip_tags($message->message)."</p>";
            }
            if (!empty($message->file)) {
                $email_content .= "<br>Prisegtas dokumentas: <a href='".\Config::get('app.url')."/uploads/messages/".$message->file."'>".\Config::get('app.url')."/uploads/messages/".$message->file."</a>";
            }
            $email_content .= "</p><p>Link??jimai<br>Pasakos komanda</p>";

            $user = $message->user;

            \Mail::send([], [], function ($message) use ($email_title, $email_content, $user) {
                $message
                    ->to($user->email)
                    ->subject($email_title)
                    ->setBody($email_content, 'text/html');
            });

            echo "Sent email to ".$user->email." about message ID " . $message->id . "<br>";

            $message->email_sent = 1;
            $message->save();
        }
        echo "Automatic notification email sending ended<br>";

        echo "Automatic Timezone check started<br>";
        foreach (Group::all() as $group){
            $today = date("Y-m-d H:i");
            $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
            $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
            if($today == $summerday){
                $time = $group->time->subHour();
                $group->time = $time;
            }else if($today == $winterday){
                $time = $group->time->addHour();
                $group->time = $time;
            }
            $group->save();
        }
        echo "Events<br>";
        foreach (Event::all() as $event){
            $today = date("Y-m-d H:i");
            $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
            $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
            //echo $today." === ".$summerday."<br>";
            if($today == $summerday){
                $time = $event->date_at->subHour();
                //echo $time."<br>";
                $event->date_at = $time;
            }else if($today == $winterday){
                $time = $event->date_at->addHour();
                $event->date_at = $time;
            }
            $event->save();
        }
        echo "Meeting<br>";
        foreach (Meeting::all() as $meet){
            $today = date("Y-m-d H:i");
            $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
            $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
            if($today == $summerday){
                $time = $meet->date_at->subHour();
                //echo $time."<br>";
                $meet->date_at = $time;
            }else if($today == $winterday){
                $time = $meet->date_at->addHour();
                $meet->date_at = $time;
            }
            $meet->save();
        }
        echo "Automatic Timezone check ended<br>";
    }

    public function checkPaymentsFromStripe(Request $request) {
        $stripe = new \Stripe\StripeClient(
            \Config::get("app.stripe_secret")
        );

        $data = $stripe->checkout->sessions->all(['limit' => 1000])->data;
        $payments = Payment::where('payment_status', '!=', 'paid')->where('payment_status', '!=', 'free_lesson')->latest()->get()->keyBy('payment_id');
        foreach ($data as $stripePayment) {

            if ($stripePayment['payment_status'] === 'paid' && isset($payments[$stripePayment['payment_intent']])) {
                $payment = $payments[$stripePayment['payment_intent']];
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


                $messageArray = $this->getCheckoutSessionSucceededUserMessage($group, $user);

                \Mail::send([], [], function ($message) use ($messageArray, $user) {
                    $message
                        ->to($user->email)
                        ->subject($messageArray['email_title'])
                        ->setBody($messageArray['email_content'], 'text/html');
                });

                $teachers = $this->getTeachersWithLessons($group);
                $email_title_admin = "Kurso u??sakymas";
                if ($group->paid) {
                    $paid = 'Taip';
                } else {
                    $paid = 'Ne';
                }

                $time = $group->time->timezone('Europe/London')->format("H:i");

                $email_content_admin = "<h1>Kurso u??sakymas</h1><p> Klientas ".  $user->name. " " .$user->surname .
                    "<br> El. pa??tas: ".$user->email.
                    "<br>Grup??: ".$group->name .
                    "<br>Grup??s ID: ".$group->id .
                    "<br>Grup??s tipas: ".$group->type .
                    "<br>Mokama: ".$paid .
                    "<br>laikas: ".$time .
                    "<br>Prad??ia: ".$group->start_date .
                    "<br>Mokytoja(-os): ".join(" ", $teachers).
                    " <br>Vaikas(-ai): ".join(" ", $student_names).
                    " <br>Am??ius: ".join(" ", $student_birthDays).
                    ".</p>";

                \Mail::send([], [], function ($message) use ($email_title_admin, $email_content_admin, $user) {
                    $message
                        ->to(\Config::get('app.email'))
                        ->subject($email_title_admin)
                        ->setBody($email_content_admin, 'text/html');
                });
            }
        }
    }

    private function getCheckoutSessionSucceededUserMessage($group, $user) {
        $timezone = \Cookie::get("user_timezone", "Europe/London");
        if (!empty($user->time_zone)) {
            $timezone = $user->time_zone;
        }

        $email_title = "Registracijos patvirtinimas";
        $email_content = "<p>Sveiki,<br>".
            "d??iaugiam??s, kad prisijungsite prie Pasakos pamok??!<br>".
            "J??s?? detal??s apa??ioje:<br>".
            $group->name."<br>".
            $group->display_name." ".$group->time->timezone($timezone)->format("H:i")." (".$timezone.")<br>".
            "Kursas vyks  ". \Carbon\Carbon::parse($group->start_date)->format("m.d")." - ". \Carbon\Carbon::parse($group->end_date)->format("m.d")." (".$group->course_length." sav.)<br>".
            "Savo <a href='".\Config::get('app.url')."/login'>Pasakos paskyroje</a> patogiai prisijungsite ?? pamokas, rasite nam?? darbus ir gal??site bendrauti su kitais nariais. </p>".
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

    private function registerUserCoupon($payment) {
        $coupon = Coupon::where('code', $payment->discount_code)->first();

        if (!empty($coupon)) {
            $userCoupon = new UserCoupon();
            $userCoupon->user_id = $payment->user_id;
            $userCoupon->coupon_id = $coupon->id;
            $userCoupon->redeemed_at = Carbon::now()->timestamp;
        }
    }

}