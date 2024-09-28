<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('post_index');
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
             * No of pages in pagination
             * @var int $page
             * @example 1
             */
            'page' => ['nullable', 'integer'],

            /**
             * No of items per page in pagination
             * @var int $size
             * @example 10
             */
            'size' => ['nullable', 'integer'],

            /**
             * Title of the post
             * @var string $title
             * @example Post Title
             */
            'title' => ['nullable', 'string'],

            /**
             * Author of the post
             * @var string $author
             * @example John Doe
             */
            'author' => ['nullable', 'string'],

            /**
             * Category of the post
             * @var string $category
             * @example Category Name
             */
            'category' => ['nullable', 'string'],

            /**
             * Tag of the post
             * @var string $tag
             * @example Tag Name
             */
            'tag' => ['nullable', 'string'],
        ];
    }
}
