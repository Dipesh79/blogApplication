<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    /**
     * @operationId Login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->custom_error([], 'The provided credentials are incorrect.', '422');
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $userResource = new UserResource($user);
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success($userResource, 'User logged in successfully');

    }

    /**
     * @operationId Logout
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
        } catch (Exception $exception) {
            return $this->api_error($exception);
        }
        return $this->api_success([], 'User logged out successfully');
    }

}
