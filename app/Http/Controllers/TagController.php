<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\DeleteRequest;
use App\Http\Requests\Tag\IndexRequest;
use App\Http\Requests\Tag\ShowRequest;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;

class TagController extends ApiBaseController
{
    /**
     * @operationId Tag Index
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $tags = Tag::query();
        if ($request->search) {
            $tags = $tags->customFilter($request->search);
        }
        if ($request->page && $request->size) {
            $tags = $tags->paginate($request->size);
        } else {
            $tags = $tags->get();
        }
        $response = new TagCollection($tags);
        return $this->api_success($response, 'Tags retrieved successfully');

    }

    /**
     * @operationId Tag Store
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $tag = Tag::create(
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                ]
            );
            $response = new TagResource($tag);
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($response, 'Tag created successfully');
    }

    /**
     * @operationId Tag Show
     * @param ShowRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(ShowRequest $request, string $id): JsonResponse
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return $this->custom_error([], 'Tag not found', 404);
        }
        $response = new TagResource($tag);
        return $this->api_success($response, 'Tag retrieved successfully');
    }

    /**
     * @operationId Tag Update
     * @param UpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        try {
            $tag = Tag::find($id);
            if (!$tag) {
                return $this->custom_error([], 'Tag not found', 404);
            }
            $tag->update(
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                ]
            );
            $response = new TagResource($tag);
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($response, 'Tag updated successfully');
    }

    /**
     * @operationId Tag Delete
     * @param DeleteRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, string $id): JsonResponse
    {
        try {
            $tag = Tag::find($id);
            if (!$tag) {
                return $this->custom_error([], 'Tag not found', 404);
            }
            $tag->delete();
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success([], 'Tag deleted successfully');
    }
}
