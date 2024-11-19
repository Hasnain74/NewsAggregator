<?php
namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 */
class LoginRequest extends FormRequest
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
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email is required.',
            'email.exists' => 'The provided email does not match any account.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.string' => 'The password must be a string.',
        ];
    }
}
