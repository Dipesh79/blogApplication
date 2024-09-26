<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class AuthenticationController extends ApiBaseController
{
    /**
     * @operationId Register
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());
            $user->assignRole(Role::findByName('Author'));
            $userResource = new UserResource($user);

        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($userResource, 'User created successfully');

    }

}
