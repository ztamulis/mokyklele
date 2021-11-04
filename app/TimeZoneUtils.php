<?php

namespace App;

use Carbon\Carbon;

class TimeZoneUtils
{
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

    /**
     * @param $date
     * @return string
     */
    public static function updateTime($date) {
        if (self::isDateInSummerTime($date)) {
            return $date;
        }
        return Carbon::createFromDate($date)->addHour()->format('Y-m-d H:i');
    }

    public static function isDateInSummerTime($date) {
        $year = Carbon::createFromDate($date)->format('Y');
        $summerday = date(TimeZoneUtils::summerTimeStartCustom($year)." 5:00");
        $winterday = date(TimeZoneUtils::summerTimeEndCustom($year)." 5:00");
        return $date > $summerday && $date < $winterday;
    }


    public static function isSummerTime() {
        $today = date("Y-m-d H:i");
        $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
        $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
        return $today > $summerday && $today < $winterday;
    }

    public static function summerTimeStartCustom($year) {
        $tz = new \DateTimeZone('Europe/London');
        $start = new \DateTime(date($year."-01-01"), $tz);
        $end = new \DateTime(date($year.'-12-31'), $tz);
        return explode("T",$tz->getTransitions($start->format('U'), $end->format('U'))[1]['time'])[0];
    }

    public static function summerTimeEndCustom($year) {
        $tz = new \DateTimeZone('Europe/London');
        $start = new \DateTime(date($year."-01-01"), $tz);
        $end = new \DateTime(date($year.'-12-31'), $tz);
        return explode("T",$tz->getTransitions($start->format('U'), $end->format('U'))[2]['time'])[0];
    }
}