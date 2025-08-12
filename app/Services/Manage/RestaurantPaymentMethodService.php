<?php

namespace App\Services\Manage;

use App\Models\RestaurantPaymentMethod;
use Illuminate\Database\Eloquent\Collection;

class RestaurantPaymentMethodService
{
    public function getAllByRestaurant(int $restaurantId)
    {
        $items = RestaurantPaymentMethod::with(['paymentMethod.translations'])
            ->where('restaurant_id', $restaurantId)
            ->get();

        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'restaurant_id' => $item->restaurant_id,
                'payment_method_id' => $item->payment_method_id,
                'payment_method_name' => $item->paymentMethod->translated_name
                    ?? $item->paymentMethod->code
            ];
        });
    }

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
}
