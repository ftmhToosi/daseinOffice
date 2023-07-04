<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUpdateRequest extends FormRequest
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
            'image' => 'nullable',
            'body_fa' => 'nullable',
            'chief_name_fa' => 'nullable',
            'chief_image' => 'nullable',
            'is_english' => 'nullable',
            'body_en' => 'nullable',
            'chief_name_en' => 'nullable',
            'galleries' => 'nullable'
        ];
    }
}
