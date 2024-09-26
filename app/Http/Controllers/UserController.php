<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends ApiBaseController
{
    /**
     * @operationId User Index
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $users = User::query();
        if ($request->search) {
            $users = $users->customFilter($request->search);
        }
        if ($request->page && $request->size) {
            $users = $users->paginate($request->size);
        } else {
            $users = $users->get();
        }
        $response = new UserCollection($users);
        return $this->api_success($response, 'Users retrieved successfully');
    }

    /**
     * @operationId User Store
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]
            );
            $role = $request->role ? Role::find($request->role) : Role::findByName('Author');
            $user->assignRole($role);
            $response = new UserResource($user);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->api_error($exception);
        }
        DB::commit();
        return $this->api_success($response, 'User created successfully.');
    }

    /**
     * @operationId User Show
     * @param ShowRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(ShowRequest $request, string $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return $this->custom_error([], 'User not found', 404);
        }
        $response = new UserResource($user);
        return $this->api_success($response, 'User retrieved successfully.');
    }

    /**
     * @operationId User Update
     *
     * @param UpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return $this->custom_error([], 'User not found', 404);
            }
            $user->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                ]
            );
            $response = new UserResource($user);
        } catch (\Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($response, 'User updated successfully.');
    }

    /**
     * @operationId User Delete
     *
     * @param DeleteRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, string $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return $this->custom_error([], 'User not found', 404);
            }
            $user->delete();
        } catch (\Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success([], 'User deleted successfully.');
    }
}
