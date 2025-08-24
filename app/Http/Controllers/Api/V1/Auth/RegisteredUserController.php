<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Helpers\ApiResponseHelper;
use App\Http\Resources\UserMinimalResource;
use App\Services\Auth\AuthService;

class RegisteredUserController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        $token = $user->createToken('api')->plainTextToken;

        return ApiResponseHelper::single(
            ['user' => new UserMinimalResource($user), 'token' => $token],
            'User registered successfully',
            201
        );
    }
}
