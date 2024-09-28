<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\DeleteRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class CommentController extends ApiBaseController
{
    /**
     * @operationId Comment Store
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $post = Post::find($request->post);
        if (!$post) {
            return $this->custom_error([], 'Post not found', 404);
        }
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);
        $response = new CommentResource($comment);
        return $this->api_success($response, 'Comment created successfully');
    }


    /**
     * @operationId Comment Update
     * @param UpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        $post = Post::find($request->post);
        if (!$post) {
            return $this->custom_error([], 'Post not found', 404);
        }
        $comment = $post->comments()->find($id);
        if (!$comment) {
            return $this->custom_error([], 'Comment not found', 404);
        }
        $comment->update([
            'content' => $request->content,
        ]);
        $response = new CommentResource($comment);
        return $this->api_success($response, 'Comment updated successfully');
    }

    /**
     * @operationId Comment Delete
     * @param DeleteRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, string $id): JsonResponse
    {
        $post = Post::find($request->post);
        if (!$post) {
            return $this->custom_error([], 'Post not found', 404);
        }
        $comment = $post->comments()->find($id);
        if (!$comment) {
            return $this->custom_error([], 'Comment not found', 404);
        }
        $comment->delete();
        return $this->api_success([], 'Comment deleted successfully');
    }
}
