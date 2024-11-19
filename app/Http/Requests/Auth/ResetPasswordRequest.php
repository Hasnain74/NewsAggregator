<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/*
 * ResetPasswordRequest
 * @package App\Http\Requests\Auth
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'token' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
            'password.min' => 'Password must be at least 8 characters',
            'token.required' => 'Token is required',
        ];
    }
}
