<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            /**
             * Name of the user
             * @var string $name
             * @example "John"
             * @required
             */
            'name' => ['required'],
            /**
             * Email of the user. Must be unique
             * @var string $email
             * @example "user@gmail.com"
             **/
            'email' => ['required', 'email', 'unique:users'],
            /**
             * Password of the user. Must be at least 8 characters
             * @var string $password
             * @example "password"
             */
            'password' => ['required', 'min:8', 'confirmed'],
            /**
             * Password confirmation
             * @var string $password_confirmation
             * @example "password"
             * @required
             */
            'password_confirmation' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password does not match',
            'password_confirmation.required' => 'Password confirmation is required',
        ];

    }
}
