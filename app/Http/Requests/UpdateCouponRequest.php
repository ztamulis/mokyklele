<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCouponRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->role != "admin") {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code' => 'required|unique:coupons,id,'.$this->coupon->id.'|max:32',
            'type' => 'required',
            'discount' => 'required|numeric',
            'use_limit' => 'required|numeric',
            'active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Neįvestas kupono kodas',
            'code.max' => 'Kupono kodas per ilgas',
            'code.unique' => 'Toks pavadinimas jau yra',
            'type.required' => 'Privalomas tipas',
            'discount.required' => 'Privaloma įvesti nuolaidos dydį',
            'use_limit.required' => 'Privaloma įvesti naudojimo limitą',
            'active.required' => 'Privaloma pasirinkti aktyvumą',
        ];
    }
}
