<?php

namespace App\Http\Controllers\Api\v1\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Services\PaymentMethods\PaymentMethodService;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodService $paymentMethodService) {}

    /**
     * Display a listing of the payment methods.
     */
    public function index(): JsonResponse
    {
        $paymentMethods = $this->paymentMethodService->getActiveWithTranslations();

        return response()->json([
            'data' => $paymentMethods
        ]);
    }

    /**
     * Display the specified payment method.
     */
    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->load('translations');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $paymentMethod->id,
                'code' => $paymentMethod->code,
                'name' => $paymentMethod->translated_name ?? $paymentMethod->code,
            ],
        ]);
    }
}
