<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('category_create');
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
             * Name of category
             * @var string $name
             * @example Electronics
             */
            'name' => ['required', 'string'],

            /**
             * Slug of category
             * @var string $slug
             * @example electronics
             * @unique categories
             */
            'slug' => ['required', 'string', 'unique:categories,slug']
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug field must be a string.',
            'slug.unique' => 'The slug has already been taken.'
        ];
    }
}
