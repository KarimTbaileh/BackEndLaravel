<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.sometimes' => 'Email is optional but must be a valid email address if provided',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'password.sometimes' => 'Password is optional but must be at least 6 characters if provided',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ];
    }
}
