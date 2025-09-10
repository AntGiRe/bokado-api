<?php

namespace App\Http\Controllers\Api\v1\Manage\Restaurants;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\StoreRestaurantPaymentMethodRequest;
use App\Services\Manage\RestaurantPaymentMethodService;
use App\Services\Utils\TranslationFallbackService;
use App\Http\Traits\HandlesApiResources;
use App\Models\Restaurant;
use App\Models\RestaurantPaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantPaymentMethodController extends Controller
{
    use HandlesApiResources;

    protected $translationService;

    public function __construct(private RestaurantPaymentMethodService $service, TranslationFallbackService $translationService) {
        $this->translationService = $translationService;
    }

    protected function getTranslationService()
    {
        return $this->translationService;
    }

    public function index(Request $request, Restaurant $restaurant): JsonResponse
    {
        return $this->resourceIndex($request, RestaurantPaymentMethod::class, ['paymentMethod.translations'], true);
    }

    public function show(Request $request, Restaurant $restaurant, $payment_method): JsonResponse
    {
        $item = $this->service->getByRestaurantAndPaymentMethod($restaurant->id, $payment_method);

        return $this->resourceShow($item->id, RestaurantPaymentMethod::class, ['paymentMethod.translations'], true);
    }

    public function store(StoreRestaurantPaymentMethodRequest $request, Restaurant $restaurant): JsonResponse
    {
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->id;

        $existingItem = $this->service->getByRestaurantAndPaymentMethodIfExists($restaurant->id, $data['payment_method_id']);

        if ($existingItem) {
            $item = $existingItem;
        } else {
            $item = $this->service->create($data)->load('paymentMethod.translations');
        }

        return $this->resourceShow($item->id, RestaurantPaymentMethod::class, ['paymentMethod.translations'], true, false, 'Payment method added successfully', 201);
    }

    public function destroy($restaurantId, $paymentMethodId): JsonResponse
    {
        $this->service->deleteByRestaurantAndPaymentMethod($restaurantId, $paymentMethodId);

        return ApiResponseHelper::message('Payment method removed successfully');
    }
}
