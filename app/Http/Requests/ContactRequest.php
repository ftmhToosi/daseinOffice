<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_fa' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
            'fax_number' => 'nullable',
            'email' => 'required',
            'body_fa' => 'nullable',
            'is_english' => 'required',
            'address_en' => 'required_if:is_english,true',
            'body_en' => 'nullable',
        ];
    }
}
