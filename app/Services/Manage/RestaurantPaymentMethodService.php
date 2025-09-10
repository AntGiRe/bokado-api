<?php

namespace App\Services\Manage;

use App\Models\RestaurantPaymentMethod;

class RestaurantPaymentMethodService
{

    public function getByRestaurantAndPaymentMethod(int $restaurantId, int $paymentMethodId): RestaurantPaymentMethod
    {
        return RestaurantPaymentMethod::with(['paymentMethod.translations'])
            ->where('restaurant_id', $restaurantId)
            ->where('payment_method_id', $paymentMethodId)
            ->firstOrFail();
    }

    public function deleteByRestaurantAndPaymentMethod(int $restaurantId, int $paymentMethodId): bool
    {
        $item = $this->getByRestaurantAndPaymentMethod($restaurantId, $paymentMethodId);
        return $item->delete();
    }

    public function create(array $data): RestaurantPaymentMethod
    {
        return RestaurantPaymentMethod::create($data);
    }

    public function getByRestaurantAndPaymentMethodIfExists(int $restaurantId, int $paymentMethodId): ?RestaurantPaymentMethod
    {
        return RestaurantPaymentMethod::with('paymentMethod.translations')
            ->where('restaurant_id', $restaurantId)
            ->where('payment_method_id', $paymentMethodId)
            ->first();
    }
}
