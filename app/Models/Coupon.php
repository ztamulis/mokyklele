<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    use HasFactory;


    public function userCoupons(){
        return $this->hasMany(UserCoupon::class);
    }
    protected $casts = [
        'groups' => 'json',
    ];

    protected $fillable = [
        'code',
        'groups',
        'type',
        'discount',
        'use_limit',
        'active',
        'expires_at'
    ];
}
