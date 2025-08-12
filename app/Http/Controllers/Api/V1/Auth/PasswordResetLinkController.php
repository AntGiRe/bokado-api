<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class PasswordResetLinkController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = $this->authService->sendResetLink($request->input('email'));

        return response()->json([
            'status' => __(
                $status === Password::RESET_LINK_SENT
                    ? 'A reset link will be sent if the account exists.'
                    : 'Unable to send reset link.'
            )
        ]);
    }
}
