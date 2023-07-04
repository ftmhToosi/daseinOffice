<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeblogRequest extends FormRequest
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
            'title_fa' => 'required',
            'body_fa' => 'nullable',
            'link' => 'nullable',
//            'date' => 'required',
            'description' => 'nullable',
            'keyword' => 'nullable',
            'image' => 'nullable|file|mimes:png,jpg|max:2048',
            'is_english' => 'required',
            'title_en' => 'required',
            'body_en' => 'nullable',
        ];
    }
}
