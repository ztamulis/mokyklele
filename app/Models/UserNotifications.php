<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model {
    use HasFactory;

    protected $fillable = [
        'email',
        'send_from_time',
        'user_id',
        'group_id',
        'is_sent',
        'type',
        'age_category',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }
}
