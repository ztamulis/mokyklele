<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function students(){
        return $this->belongsTo(Student::class);
    }
}
