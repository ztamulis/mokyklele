<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $dates = ['date_at'];

    public function users(){
        return $this->belongsToMany(User::class);
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