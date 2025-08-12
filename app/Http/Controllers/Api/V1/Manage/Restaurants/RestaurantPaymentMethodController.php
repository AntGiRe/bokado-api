<?php

namespace App\Http\Controllers\Api\v1\Manage\Restaurants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\StoreRestaurantPaymentMethodRequest;
use App\Services\Manage\RestaurantPaymentMethodService;
use App\Models\Restaurant;
use App\Models\RestaurantPaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class RestaurantPaymentMethodController extends Controller
{
    public function __construct(private RestaurantPaymentMethodService $service) {}

    public function index(Request $request, Restaurant $restaurant): JsonResponse
    {
        $data = $this->service->getAllByRestaurant($restaurant->id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function show(Request $request, Restaurant $restaurant, $payment_method): JsonResponse
    {
        $item = $this->service->getByRestaurantAndPaymentMethod($restaurant->id, $payment_method);

        return response()->json([
            'data' => [
                'id' => $item->id,
                'restaurant_id' => $item->restaurant_id,
                'payment_method_id' => $item->payment_method_id,
                'payment_method_name' => $item->paymentMethod->translated_name ?? $item->paymentMethod->code
            ],
        ]);
    }

    public function store(StoreRestaurantPaymentMethodRequest $request, Restaurant $restaurant): JsonResponse
    {
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->id;

        $item = $this->service->create($data)->load('paymentMethod.translations');

        return response()->json([
            'data' => [
                'id' => $item->id,
                'restaurant_id' => $item->restaurant_id,
                'payment_method_id' => $item->payment_method_id,
                'payment_method_name' => $item->paymentMethod->translated_name
                    ?? $item->paymentMethod->code
            ],
        ], 201);
    }

    public function destroy($restaurantId, $paymentMethodId): JsonResponse
    {
        $this->service->deleteByRestaurantAndPaymentMethod($restaurantId, $paymentMethodId);

        return response()->json([
            'message' => 'Deleted successfully',
        ]);
    }
}
