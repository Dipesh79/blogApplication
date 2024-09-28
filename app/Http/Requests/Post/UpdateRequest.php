<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('post_update');
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
            'slug' => ['required', 'string', 'unique:posts,slug,' . request()->route()->parameter('post')],

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
            'category' => ['required', 'integer', 'exists:categories,id'],

            /**
             * Tags of Post
             * @var array $tags
             * @example [1]
             */
            'tags' => ['nullable', 'array'],

            /**
             * Tags of Post
             * @var integer $tags .*
             * @example 1
             */
            'tags.*' => ['integer', 'exists:tags,id']
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
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'slug.required' => 'Slug is required',
            'slug.string' => 'Slug must be a string',
            'slug.unique' => 'Slug has already been taken',
            'content.required' => 'Content is required',
            'content.string' => 'Content must be a string',
            'category.required' => 'Category is required',
            'category.integer' => 'Category must be an integer',
            'category.exists' => 'Category does not exist',
            'tags.array' => 'Tags must be an array',
            'tags.*.integer' => 'Tags must be an integer',
            'tags.*.exists' => 'Tags does not exist',
        ];
    }
}
