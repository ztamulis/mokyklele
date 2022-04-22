<?php


namespace App\Http\Helpers;


use App\Models\Group;
use App\Models\Meeting;
use App\Models\User;
use App\TimeZoneUtils;
use Carbon\Carbon;

class UserNotificationEmailHelper {
    public static function getFinishedEmail(
        Group $group,
        User $user,
        string $emailType,
        ?Meeting $meeting,
        string $emailContent
    ) {
        \Carbon\Carbon::setLocale('lt');

        $firstEvent = $group->events()->orderBy('date_at', 'asc')->first();
        $firstEventDate = TimeZoneUtils::updateTime($firstEvent->date_at, $firstEvent->updated_at)->setTimezone($user->time_zone);
        $dayOfWeekKey = $firstEventDate->dayOfWeek;
        $emailContent = str_replace('{grupe}', $group->color(), $emailContent);
        $emailContent = str_replace('{grupes-savaites-diena}', $group->getWeekDayGramCase($dayOfWeekKey), $emailContent);
        $emailContent = str_replace('{pamokos-laikas}', $firstEventDate->format('H:i'), $emailContent);
        $emailContent = str_replace('{vartotojo-laiko-juosta}', $user->time_zone, $emailContent);
        $emailContent = str_replace('{grupe-kilmininko-linksnis}', $group->getGroupTypeGenitiveCase(), $emailContent);
        $emailContent = str_replace('{pamokos-diena-angliskai}', $firstEventDate->formatLocalized('%A'), $emailContent);

        if (!empty($meeting)) {
            $meetingDate = TimeZoneUtils::updateTime($meeting->date_at, $meeting->updated_at)
                ->setTimezone($user->time_zone);

            $emailContent = str_replace('{susitikimo-menesis-kilmininkas}', $group->getMonthGenitiveCase($firstEventDate->month), $emailContent);
            $emailContent = str_replace('{susitikimo-diena-skaicius}', $meetingDate->format('d'), $emailContent);
            $emailContent = str_replace('{susitikimo-valanda}', $meetingDate->format('H:i'), $emailContent);
        }

        if ($group->events()->where('date_at' ,'>=', Carbon::now())
            ->orderBy('date_at', 'asc')
            ->first()
            ->date_at
            ->isSameDay(Carbon::now())
        ) {
            $emailContent = str_replace('rytoj', 'šiandien', $emailContent);
            $emailContent = str_replace('tomorrow', 'today', $emailContent);
        }

        return $emailContent;
    }





}