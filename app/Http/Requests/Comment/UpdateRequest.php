<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $comment = Comment::find($this->route('comment'));
        if (!$comment) {
            return false;
        }
        $commentUser = $comment->user_id;
        return auth()->user()->can('comment_update') && ($commentUser === auth()->id() || auth()->user()->hasRole('Admin'));
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
             * Content of Comment
             * @var string $content
             * @example Content of Comment 1
             */
            'content' => ['required', 'string'],

            /**
             * Post of Comment
             * @var integer $post
             * @example 1
             */
            'post' => ['required', 'integer', 'exists:posts,id'],
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
            'content.required' => 'Content is required',
            'content.string' => 'Content must be a string',
            'post.required' => 'Post is required',
            'post.integer' => 'Post must be an integer',
            'post.exists' => 'Post not found',
        ];
    }
}
