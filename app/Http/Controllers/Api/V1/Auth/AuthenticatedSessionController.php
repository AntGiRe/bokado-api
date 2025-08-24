<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserMinimalResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthService;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private AuthService $authService) {}

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $user = $this->authService->attemptLogin($credentials, false, $request);

        $token = $user->createToken('api')->plainTextToken;

        return ApiResponseHelper::single(
            ['user' => new UserMinimalResource($user), 'token' => $token],
            'Login successful'
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponseHelper::message('Logged out successfully');
    }
}
