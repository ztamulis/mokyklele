<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionForm extends Model {
    use HasFactory;

    protected $table = 'question_form';
    public $timestamps = true;

    protected $casts = [
        'week_days' => 'json'
    ];

    protected $fillable = [
        'email',
        'language_level',
        'week_days',
        'times_per_week',
        'comment'
    ];

}
