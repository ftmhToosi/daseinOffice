<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'type_id' => 'required',
            'status_id' => 'required',
            'scale_id' => 'required',
            'body_fa' => 'required',
            'image' => 'required|file|mimes:png,jpg|max:2048',
            'video' => 'nullable|file|mimes:mp4,mpeg,avi,wmv,mkv.mov,webm',
            'location_fa' => 'nullable',
            'team_fa' => 'nullable',
            'client_fa' => 'nullable',
            'supervision_fa' => 'nullable',
            'construction_fa' => 'nullable',
            'landscape_fa' => 'nullable',
            'structural_design_fa' => 'nullable',
            'mechanical_fa' => 'nullable',
            'electrical_fa' => 'nullable',
            'revolving_rooms_fa' => 'nullable',
            'photographer_fa' => 'nullable',
            'is_english' => 'required',
            'title_en' => 'required',
            'body_en' => 'required_if:is_english,true',
            'location_en' => 'nullable',
            'team_en' => 'nullable',
            'client_en' => 'nullable',
            'supervision_en' => 'nullable',
            'construction_en' => 'nullable',
            'landscape_en' => 'nullable',
            'structural_design_en' => 'nullable',
            'mechanical_en' => 'nullable',
            'electrical_en' => 'nullable',
            'revolving_rooms_en' => 'nullable',
            'photographer_en' => 'nullable',
            'galleries' => 'required'

        ];
    }
}
