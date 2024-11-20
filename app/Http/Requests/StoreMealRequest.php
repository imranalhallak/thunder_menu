<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMealRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this if you want to implement authorization logic
    }


public function rules()
{
    return [
        'arabic_name' => 'required|string|max:255',
        'turkish_name' => 'required|string|max:255',
        'english_name' => 'required|string|max:255',
        'arabic_description' => 'nullable|string',
        'turkish_description' => 'nullable|string',
        'english_description' => 'nullable|string',
        'price1' => 'nullable',
        'price2' => 'nullable',
        'price3' => 'nullable',
        'menu_id' => 'required',
    ];
}
}
