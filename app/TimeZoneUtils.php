<?php

namespace App;

use Carbon\Carbon;
use Faker\Provider\DateTime;

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

    public static function updateTime($date) {
        if (is_int(strpos(\Cookie::get("user_timezone", "GMT"), 'Europe'))) {
            return Carbon::createFromDate($date)->addHour()->format('Y-m-d H:i');
        }
        return $date;
    }




    public static function isSummerTime() {
        $today = date("Y-m-d H:i");
        $summerday = date(TimeZoneUtils::summerTimeStart()." 5:00");
        $winterday = date(TimeZoneUtils::summerTimeEnd()." 5:00");
        $date = \Carbon\Carbon::now();
        return $today > $summerday && $today < $winterday;
    }
}