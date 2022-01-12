<?php


namespace App\Http\Traits;


use App\Models\Group;
use App\Models\UserNotifications;
use Carbon\Carbon;

trait NotificationsTrait
{
    private function insertUserNotification($user, Group $group) {
        UserNotifications::updateOrCreate(
            [
                'user_id' => $user->id,
                'group_id' => $group->id,
            ],
            [
                'user_id' => $user->id,
                'email' => $user->email,
                'group_id' => $group->id,
                'type' => $group->type,
                'age_category' => $group->age_category,
                'send_from_time' => $this->getSendFromTime($group),
            ]
        );
    }

    private function getSendFromTime(Group $group) {
        $time = $group->events()->orderBy('date_at', 'asc')->first();
        $timeDate = $time->date_at->subDays(1)->format('Y-m-d');
        return Carbon::parse($timeDate)->setTimezone('Europe/London')
            ->setTime(8,0,0)
            ->timestamp;
    }

}