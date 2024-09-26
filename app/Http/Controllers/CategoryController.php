<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\DeleteRequest;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Requests\Category\ShowRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiBaseController
{
    /**
     * @operationId Category Index
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $categories = Category::query();
        if ($request->search) {
            $categories = $categories->customFilter($request->search);
        }
        if ($request->page && $request->size) {
            $categories = $categories->paginate($request->size);
        } else {
            $categories = $categories->get();
        }
        $response = new CategoryCollection($categories);
        return $this->api_success($response, 'Categories retrieved successfully');
    }

    /**
     * @operationId Category Store
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $category = Category::create(
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                ]
            );
            $response = new CategoryResource($category);

        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($response, 'Category created successfully');
    }

    /**
     * @operationId Category Show
     * @param ShowRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(ShowRequest $request, string $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->custom_error([], 'Category not found', 404);
        }
        $response = new CategoryResource($category);
        return $this->api_success($response, 'Category retrieved successfully');
    }


    /**
     * @operationId Category Update
     * @param UpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return $this->custom_error([], 'Category not found', 404);
            }
            $category->update(
                [
                    'name' => $request->name,
                    'slug' => $request->slug,
                ]
            );
            $response = new CategoryResource($category);
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($response, 'Category updated successfully');
    }

    /**
     * @operationId Category Delete
     * @param DeleteRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, string $id): JsonResponse
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return $this->custom_error([], 'Category not found', 404);
            }
            $category->delete();
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success([], 'Category deleted successfully');
    }
}
