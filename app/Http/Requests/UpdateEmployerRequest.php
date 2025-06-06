<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerRequest extends FormRequest
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
            'language' => 'sometimes|string|regex:/^[A-Za-z\s\-]+$/',
            'job_title' => 'sometimes|string|max:30|regex:/^[A-Za-z\s\-]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'language.sometimes' => 'Language is optional but must be a string if provided',
            'language.string' => 'Language must be a string',
            'job_title.sometimes' => 'Job title is optional but must be a string if provided',
            'job_title.string' => 'Job title must be a string',
            'job_title.max' => 'Job title may not be greater than 30 characters',
        ];
    }
}
