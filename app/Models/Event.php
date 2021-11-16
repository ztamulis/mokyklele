<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dates = ['date_at'];

    public function groups(){
        return $this->belongsToMany(Group::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function author() {
        return $this->belongsTo(User::class);
    }
    public function teacher() {
        return $this->belongsTo(User::class);
    }
    public function typeText() {
        if($this->type == "lesson") {
            return "Pamoka";
        }
        if($this->type == "individual") {
            return "Ind. pamoka";
        }
        if($this->type == "free") {
            return "Nemokama pam.";
        }
    }

    public function getAdminTimeAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = date("Y-03-28 5:00");
        $winterday = date("Y-10-31 5:00");
        if($today > $summerday && $today < $winterday){
            return $this->date_at->addHour();
        }
        return $this->date_at;
    }

    public function getAdminTimeModifierAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = date("Y-03-28 5:00");
        $winterday = date("Y-10-31 5:00");
        if($today > $summerday && $today < $winterday){
            return "GMT+1";
        }
        return "GMT+0";
    }
}
