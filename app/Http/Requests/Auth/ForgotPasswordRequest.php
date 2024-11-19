<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ForgotPasswordRequest
 * @package App\Http\Requests\Auth
 */
class ForgotPasswordRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::exists('users', 'email')],
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
            'email.exists' => 'The provided email does not match any account',
        ];
    }
}
