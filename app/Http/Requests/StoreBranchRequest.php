<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'mode' => 'nullable|string|max:50',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
        ];
    }
}
