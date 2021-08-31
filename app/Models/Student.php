<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    protected $dates = ['birthday'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

    public function getAgeAttribute() {
        if(!$this->birthday)
            return "";
        $age = $this->birthday->age;
        $text = " metai";
        if(Str::endsWith($age."", "1")){
            $text = " metas";
        }
        if($age % 10 == 0 || ($age > 10 && $age < 20)){
            $text = " metų";
        }
        return $age . $text;
    }
}
