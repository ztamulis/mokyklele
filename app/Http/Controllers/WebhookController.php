<?php

namespace App\Http\Controllers;

use App\Http\Traits\CheckoutEmailsTrait;
use App\Http\Traits\NotificationsTrait;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Student;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    use NotificationsTrait;
    use CheckoutEmailsTrait;

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

        $this->sendCheckoutSessionSucceededUserMessage($group, $user);

        $date = Carbon::parse($group->start_date)->setTimezone($user->time_zone);
        $now = Carbon::now()->setTimezone($user->time_zone);

        $diff = $date->diffInDays($now);
        //find a better solution;
        if ($diff > 0) {
            $this->insertUserNotification($user, $group);
        }

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);



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

        $this->sendCheckoutSessionSucceededUserMessage($group, $user);

        $date = Carbon::parse($group->start_date)->setTimezone($user->time_zone);
        $now = Carbon::now()->setTimezone($user->time_zone);

        $diff = $date->diffInDays($now);
        //find a better solution;
        if ($diff > 0) {
            $this->insertUserNotification($user, $group);
        }

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);
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

}