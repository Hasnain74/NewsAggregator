<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/*
 * UserPreferenceRequest
 * @package App\Http\Requests
 */
class UserPreferenceRequest extends FormRequest
{
    /*
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /*
     * Get the validation rules that apply to the request.
     *  @return array
     */
    public function rules(): array
    {
        return [
            'sources' => ['nullable', 'array'],
            'categories' => ['nullable', 'array'],
            'authors' => ['nullable', 'array'],
        ];
    }

    /*
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages(): array
    {
        return [
            'sources.array' => 'Sources must be an array',
            'categories.array' => 'Categories must be an array',
            'authors.array' => 'Authors must be an array',
        ];
    }
}
