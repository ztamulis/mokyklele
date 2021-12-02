<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model {
    public $timestamps = true;

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];
}
