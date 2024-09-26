<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('user_create');
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
             * Name of the User
             * @var string $name
             * @example John Doe
             **/
            'name' => ['required', 'string'],

            /**
             * Email of the User
             * @var string $email
             * @example johndoe@gmail.com
             **/
            'email' => ['required', 'email', 'unique:users,email'],

            /**
             * Password of the User
             * @var string $password
             * @example password
             **/
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            /**
             * Password Confirmation of the User
             * @var string $password_confirmation
             * @example password
             */
            'password_confirmation' => ['required', 'string', 'min:8'],

            /**
             * Role of the User
             * @var string $role
             * @example 2
             **/
            'role' => ['nullable', 'exists:roles,id'],

        ];
    }
}
