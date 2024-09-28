<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('post_create');
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
             * Title of Post
             * @var string $title
             * @example Post 1
             */
            'title' => ['required', 'string'],

            /**
             * Slug of Post
             * @var string $slug
             * @example post-1
             * @unique posts
             */
            'slug' => ['required', 'string', 'unique:posts,slug'],

            /**
             * Content of Post
             * @var string $content
             * @example Content of Post 1
             */
            'content' => ['required', 'string'],

            /**
             * Category of Post
             * @var integer $category
             * @example 1
             */
            'category' => ['required', 'integer','exists:categories,id'],

            /**
             * Tags of Post
             * @var array $tags
             * @example [1]
             */
            'tags' => ['required', 'array'],

            /**
             * Tags of Post
             * @var integer $tags.*
             * @example 1
             */
            'tags.*' => ['integer', 'exists:tags,id']
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
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug field must be a string.',
            'slug.unique' => 'The slug has already been taken.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content field must be a string.',
            'category.required' => 'The category field is required.',
            'category.integer' => 'The category field must be an integer.',
            'category.exists' => 'The selected category is invalid.',
            'tags.required' => 'The tags field is required.',
            'tags.array' => 'The tags field must be an array.',
            'tags.*.integer' => 'The tags field must contain only integers.',
            'tags.*.exists' => 'The selected tags is invalid.'
        ];
    }
}
