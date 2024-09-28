<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\DeleteRequest;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\ShowRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends ApiBaseController
{
    /**
     * @operationId Post Index
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $posts = Post::query();
        if ($request->title) {
            $posts = $posts->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->author) {
            $posts = $posts->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->author . '%');
            });
        }
        if ($request->category) {
            $posts = $posts->whereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->category . '%');
            });
        }
        if ($request->tag) {
            $posts = $posts->whereHas('tags', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->tag . '%');
            });
        }
        if ($request->page && $request->size) {
            $posts = $posts->paginate($request->size);
        } else {
            $posts = $posts->get();
        }
        $response = new PostCollection($posts);
        return $this->api_success($response, 'Posts retrieved successfully');
    }

    /**
     * @operationId Post Store
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Post::create(
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'category_id' => $request->category,
                    'user_id' => auth()->id(),
                ]
            );

            $post->tags()->attach($request->tags);

            $response = new PostResource($post);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->api_error($exception);
        }
        DB::commit();
        return $this->api_success($response, 'Post created successfully');
    }

    /**
     * @operationId Post Show
     * @param ShowRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(ShowRequest $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->custom_error([], 'Post not found', 404);
        }
        $response = new PostResource($post);
        return $this->api_success($response, 'Post retrieved successfully');
    }

    /**
     * @operationId Post Update
     * @param UpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            if (!$post) {
                return $this->custom_error([], 'Post not found', 404);
            }
            $post->update(
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'category_id' => $request->category,
                ]
            );
            $post->tags()->sync($request->tags);

            $response = new PostResource($post);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->api_error($exception);
        }
        DB::commit();
        return $this->api_success($response, 'Post updated successfully');
    }

    /**
     * @operationId Post Destroy
     * @param DeleteRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            if (!$post) {
                return $this->custom_error([], 'Post not found', 404);
            }
            $post->tags()->detach();
            $post->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->api_error($exception);
        }
        DB::commit();
        return $this->api_success([], 'Post deleted successfully');
    }
}
