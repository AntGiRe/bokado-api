<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Services\Auth\AuthService;
use App\Helpers\ApiResponseHelper;


class NewPasswordController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->authService->resetPassword($validated);

        return ApiResponseHelper::message(__('Your password has been reset.'));
    }
}
