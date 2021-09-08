<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\TimeZoneUtils;

class Group extends Model
{

    protected $dates = ['time' , 'time_2'];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function group_message(){
        return $this->hasMany(GroupMessage::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }

    public function color(){
        if($this->type == "yellow"){
            return "Geltona";
        }
        if($this->type == "green"){
            return "Žalia";
        }
        if($this->type == "blue"){
            return "Mėlyna";
        }
        if($this->type == "red"){
            return "Raudona";
        }
    }

    public function lessonsText($lessons){
        if($lessons == 1){
            return "pamoka";
        }else if($lessons >= 2 && $lessons <= 9){
            return "pamokos";
        }
        return "pamokų";
    }

    public function adjustedPrice($coupon = null) {
        $price = $this->price;

        if ($this->type !== 'individual') {
            $price = max(0, $this->price - $this->events()->where("date_at", "<", \Carbon\Carbon::now())->count() * 8);
        }

        if (!empty($coupon) && $coupon->type === 'percent') {
            $price = $price - ($price * $coupon->discount / 100);
        }
        return $price;
    }

    public function hasAdjustedPrice() {
        return $this->adjustedPrice() != $this->price;
    }

    public function getAdminTimeAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return $this->time->addHour();
        }
        return $this->time;
    }

    public function getAdminTime2Attribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return $this->time_2->addHour();
        }
        return $this->time_2;
    }

    public function getAdminTimeModifierAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return "GMT+1";
        }
        return "0 GMT";
    }
}
