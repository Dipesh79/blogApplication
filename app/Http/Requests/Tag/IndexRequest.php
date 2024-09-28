<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('tag_index');

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
         * Search Query
         * @var string $search
         * @example Tag Name
         */
        'search' => ['nullable', 'string'],
    ];
    }
}
