<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('tag_update');
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
             * Name of tag
             * @var string $name
             * @example 'Electronics'
             */
            'name' => ['required', 'string'],

            /**
             * Slug of tag
             * @var string $slug
             * @example 'electronics'
             * @unique tags
             */
            'slug' => ['required', 'string', 'unique:tags,slug,' . request()->route()->parameter('tag')],
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
            'name.string' => 'Name must be a string',
            'slug.required' => 'Slug is required',
            'slug.string' => 'Slug must be a string',
            'slug.unique' => 'Slug has already been taken',
        ];
    }
}
