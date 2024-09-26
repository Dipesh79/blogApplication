<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('user_update');
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
             * @example New Name
             */
            'name' => ['required', 'string'],

            /**
             * Email of the User
             * @var string $email
             * @example newemail@gmail.com
             */
            'email' => ['required', 'email', 'unique:users,email,'.request()->route()->parameter('user')],
        ];
    }
}
