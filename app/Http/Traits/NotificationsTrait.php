<?php


namespace App\Http\Traits;


use App\Models\Group;
use App\Models\Student;
use App\Models\UserNotifications;
use Carbon\Carbon;

trait NotificationsTrait
{
    /**
     * @param $user
     * @param Group $group
     */
    private function insertUserNotification($user, Group $group) {
        $sendFromTime = $this->getSendFromTime($group);
        if (!$sendFromTime) {
            return;
        }

        \DB::transaction(function() use($user, $group, $sendFromTime) {
            $notification = UserNotifications::lockForUpdate()->where('user_id', $user->id)->where('group_id', $group->id)->first();
            if (!empty($notification)) {
                $notification->user_id = $user->id;
                $notification->group_id = $group->id;
                $notification->email = $user->email;
                $notification->type = $group->type;
                $notification->age_category = $group->age_category;
                $notification->send_from_time = $sendFromTime;
                $notification->save();
            } else {
                UserNotifications::insert([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'group_id' => $group->id,
                    'type' => $group->type,
                    'age_category' => $group->age_category,
                    'send_from_time' => $sendFromTime,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });
    }

    /**
     * @param Student $student
     * @param int $oldStudentGroupId
     */
    private function changeOrInsertStudentNotification(Student $student, int $oldStudentGroupId):void {
        $allStudents = $student->user()->first()->students()->where('id', '!=', $student->id)->get();
        $user = $student->user()->first();
        $group = $student->group()->first();
        if (empty($group) || empty($user)) {
            return;
        }
        if (!empty($allStudents) && !$this->checkIfSameUserRegisteredToOldGroup($oldStudentGroupId, $allStudents)) {
            UserNotifications::where('user_id', $user->id)->where('group_id', $oldStudentGroupId)
                ->where('is_sent', 0)
                ->delete();
        }
        if ($group->type !== 'individual') {
            $this->insertUserNotification($user, $group);
        }
    }

    /**
     * @param Student $student
     */
    private function deleteUserNotification(Student $student) {
        $user = $student->user()->first();
        $group = $student->group()->first();
        if (empty($group) || empty($user)) {
            return;
        }
        $allStudents = $student->user()->first()->students()->where('id', '!=', $student->id)->get();
        if (!$this->checkIfSameUserRegisteredToOldGroup($group->id, $allStudents))
            UserNotifications::where('user_id', $user->id)->where('group_id', $group->id)
                ->where('is_sent', 0)
                ->delete();
    }

    /**
     * @param int $oldStudentGroupId
     * @param $allStudents
     * @return bool
     */
    private function checkIfSameUserRegisteredToOldGroup(int $oldStudentGroupId, $allStudents) {
        if (empty($allStudents)) {
            return false;
        }
        foreach ($allStudents as $student) {
            if ($student->group_id == $oldStudentGroupId) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Group $group
     * @return bool|float|int|string
     */
    private function getSendFromTime(Group $group) {
        $time = $group->events()->where('date_at' ,'>=', Carbon::now())
            ->orderBy('date_at', 'asc')
            ->first();
        if (empty($time)) {
            return false;
        }
        $timeDate = $time->date_at->subDays(1)->format('Y-m-d');
        return Carbon::parse($timeDate)->setTimezone('Europe/London')
            ->setTime(8,0,0)
            ->timestamp;
    }

}