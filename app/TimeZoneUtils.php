<?php

namespace App;

use App\Models\Group;
use Carbon\Carbon;

class TimeZoneUtils
{

    public static function fixFreeGroupstime() {
        $groups = Group::where('price', 0)->where('hidden', 0)->where('paid', 0)->get();
        foreach($groups as $group) {
            $time = Carbon::parse($group->start_date)->subHour();

            $event = $group->events()->first();

            $event->date_at = $time;
            $event->save();
        }
    }
    public static function summerTimeStart() {
        $tz = new \DateTimeZone('Europe/London');
        $start = new \DateTime(date("Y-01-01"), $tz);
        $end = new \DateTime(date('Y-12-31'), $tz);
        return explode("T",$tz->getTransitions($start->format('U'), $end->format('U'))[1]['time'])[0];
    }

    public static function summerTimeEnd() {
        $tz = new \DateTimeZone('Europe/London');
        $start = new \DateTime(date("Y-01-01"), $tz);
        $end = new \DateTime(date('Y-12-31'), $tz);
        return explode("T",$tz->getTransitions($start->format('U'), $end->format('U'))[2]['time'])[0];
    }

    public static function currentGmtModifierText() {
        if(TimeZoneUtils::isSummerTime()){
            return "GMT+1";
        }
        return "GMT+0";
    }

    public static function dateGmtModifierText($date) {
        if(Carbon::parse($date)->timezone('Europe/London')->isDST()){
            return "GMT+1";
        }
        return "GMT+0";
    }


    /**
     * @param $date
     * @param $updatedAt
     * @return string
     */
    public static function updateTime($date, $updatedAt) {
        $summerStarts = Carbon::parse(self::summerTimeStart()." 5:00");
        $summerEnds = Carbon::parse(self::summerTimeEnd()." 5:00");
        if (($summerStarts < $updatedAt
            && $updatedAt < $summerEnds)
            && !Carbon::parse($date)->timezone('Europe/London')->isDST()) {

            return Carbon::createFromDate($date)->addHour()->format('Y-m-d H:i');
        }
        if (($summerStarts > $updatedAt
                && $updatedAt < $summerEnds)
        && Carbon::parse($date)->timezone('Europe/London')->isDST()) {

            return Carbon::createFromDate($date)->subhour()->format('Y-m-d H:i');
        }
        return $date;
    }

    public static function updateTimeWithGmt($date, $updatedAt) {

        $summerStarts = Carbon::parse(self::summerTimeStart()." 5:00");
        $summerEnds = Carbon::parse(self::summerTimeEnd()." 5:00");
        if (($summerStarts < $updatedAt
                && $updatedAt < $summerEnds)
            && !Carbon::parse($date)->timezone(self::currentGmtModifierText())->isDST()) {

            return Carbon::createFromDate($date)->addHour()->format('Y-m-d H:i');
        }
        if (($summerStarts > $updatedAt
                && $updatedAt < $summerEnds)
            && Carbon::parse($date)->timezone(self::currentGmtModifierText())->isDST()) {

            return Carbon::createFromDate($date)->subhour()->format('Y-m-d H:i');
        }
        return $date;
    }

    /**
     * @param $date
     * @return string
     */
    public static function updateHoursMeetings($date, $updatedAt) {
//        Carbon::setTestNow('2022-03-23');
        $summerStarts = Carbon::parse(self::summerTimeStart()." 5:00");
        $summerEnds = Carbon::parse(self::summerTimeEnd()." 5:00");
//        var_dump($date, $updatedAt);
        if (($summerStarts < $updatedAt
                && $updatedAt < $summerEnds)
            && !Carbon::parse($date)->timezone('Europe/London')->isDST()) {

            return Carbon::createFromDate($date)->addHour()->format('H:i');
        }
//        var_dump($summerStarts > $updatedAt
//            && $updatedAt < $summerEnds)
//        && Carbon::parse($date)->timezone('Europe/London')->isDST();die();
//        if (($summerStarts > $updatedAt
//                && $updatedAt < $summerEnds)
//            && Carbon::parse($date)->timezone('Europe/London')->isDST()) {
//
//            return Carbon::createFromDate($date)->subhour()->format('H:i');
//        }
        return Carbon::createFromDate($date)->format('H:i');
    }

    public static function updateHours($date, $updatedAt) {
//        Carbon::setTestNow('2022-03-23');
        $summerStarts = Carbon::parse(self::summerTimeStart()." 5:00");
        $summerEnds = Carbon::parse(self::summerTimeEnd()." 5:00");
//        var_dump($date, $updatedAt);
        if (($summerStarts < $updatedAt
                && $updatedAt < $summerEnds)
            && !Carbon::parse($date)->timezone('Europe/London')->isDST()) {

            return Carbon::createFromDate($date)->addHour()->format('H:i');
        }
//        var_dump($summerStarts > $updatedAt
//            && $updatedAt < $summerEnds)
//        && Carbon::parse($date)->timezone('Europe/London')->isDST();die();
        if (($summerStarts > $updatedAt
                && $updatedAt < $summerEnds)
            && Carbon::parse($date)->timezone('Europe/London')->isDST()) {

            return Carbon::createFromDate($date)->subhour()->format('H:i');
        }
        return Carbon::createFromDate($date)->format('H:i');
    }


    public static function isSummerTime() {
        $today = date("Y-m-d H:i");
        $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
        $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
        return $today > $summerday && $today < $winterday;
    }

}