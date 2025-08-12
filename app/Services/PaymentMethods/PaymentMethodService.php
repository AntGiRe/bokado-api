<?php
namespace App\Services\PaymentMethods;

use App\Models\PaymentMethod;

class PaymentMethodService
{
    public function getActiveWithTranslations(): \Illuminate\Support\Collection
    {
        return PaymentMethod::with('translations')
            ->where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function ($method) {
                return [
                    'id' => $method->id,
                    'code' => $method->code,
                    'name' => $method->translated_name ?? $method->code,
                ];
            });
    }
}