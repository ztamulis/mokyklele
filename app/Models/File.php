<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
