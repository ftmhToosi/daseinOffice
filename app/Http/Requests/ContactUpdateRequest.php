<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
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
            'address_fa' => 'nullable',
            'postal_code' => 'nullable',
            'phone_number' => 'nullable',
            'fax_number' => 'nullable',
            'email' => 'nullable',
            'body_fa' => 'nullable',
            'is_english' => 'nullable',
            'address_en' => 'nullable',
            'body_en' => 'nullable',
        ];
    }
}
