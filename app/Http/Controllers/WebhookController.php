<?php

namespace App\Http\Controllers;

use App\Http\Traits\CheckoutEmailsTrait;
use App\Http\Traits\NotificationsTrait;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Student;
use App\Models\UserCoupon;
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
        } else {
            return;
        }

        $this->sendCheckoutSessionSucceededUserMessage($group, $user);

        //find a better solution;
        if ($group->type !=='individual') {
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
        } else {
            return;
        }

        $this->sendCheckoutSessionSucceededUserMessage($group, $user);

        if ($group->type !=='individual') {
            $this->insertUserNotification($user, $group);
        }

        $this->sendOrderConfirmAdminEmail($group, $student_names, $student_birthDays, $user);
    }

}