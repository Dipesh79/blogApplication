<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
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
        $postUser = $comment->post->user_id;
        return auth()->user()->can('comment_delete') && ($commentUser === auth()->id() || $postUser === auth()->id() || auth()->user()->hasRole('Admin'));
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
             * Post id
             * @var string $post
             * @example 1
             */
            'post' => ['required', 'string', 'exists:posts,id'],
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
            'post.required' => 'Post is required',
            'post.string' => 'Post must be a string',
            'post.exists' => 'Post not found',
        ];
    }
}
