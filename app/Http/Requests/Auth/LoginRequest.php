<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * @var string $email The email of the user
             * @example "admin@gmail.com"
             * @required
             */
            'email' => ['required', 'email', 'exists:users,email'],
            /**
             * @var string $password The password of the user
             * @example "password"
             * @required
             */
            'password' => ['required'],
        ];
    }

    /**
     *
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'The email does not exist.',
            'password.required' => 'The password field is required.',
        ];
    }
}
