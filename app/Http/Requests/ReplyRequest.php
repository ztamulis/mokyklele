<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
//            'message' => ['required', 'string', 'max:10000']
        ];
    }
}