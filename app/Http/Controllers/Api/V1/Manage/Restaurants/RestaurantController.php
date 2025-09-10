<?php

namespace App\Http\Controllers\Api\v1\Manage\Restaurants;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\StoreRestaurantRequest;
use App\Http\Requests\Manage\UpdateRestaurantRequest;
use App\Services\Utils\TranslationFallbackService;
use App\Http\Traits\HandlesApiResources;
use App\Services\Manage\RestaurantService;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    use HandlesApiResources;

    protected $translationService;

    public function __construct(TranslationFallbackService $translationService, private RestaurantService $service)
    {
        $this->translationService = $translationService;
    }

    protected function getTranslationService()
    {
        return $this->translationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->resourceIndex($request, Restaurant::class, ['city'], false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRestaurantRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRestaurantRequest $request)
    {
        $validated = $request->validated();

        $restaurant = $this->service->createWithOwner($validated, $request->user());

        return $this->resourceShow($restaurant->id, Restaurant::class, ['city','currency'], false, false, 'Restaurant created successfully', 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateRestaurantRequest $request
     * @param \App\Models\Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $validated = $request->validated();

        $this->service->update($restaurant, $validated);

        return $this->resourceShow($restaurant->id, Restaurant::class, ['city'], false, false, 'Restaurant updated successfully', 200);
    }

    /**
     * Display the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Restaurant $restaurant)
    {
        return $this->resourceShow($restaurant->id, Restaurant::class, ['city','currency'], false, false, 'Restaurant retrieved successfully', 200);
    }

    /**
     * Soft delete the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return ApiResponseHelper::message('Restaurant deleted successfully');
    }

    /**
     * Activate the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Restaurant $restaurant)
    {
        if (!$restaurant->isReadyToActivate()) {
            return ApiResponseHelper::message('The restaurant cannot be activated because it is missing required settings.', 422);
        }

        $restaurant->is_active = true;
        $restaurant->save();

        return ApiResponseHelper::message('Restaurant activated successfully.');
    }

    /**
     * Deactivate the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(Restaurant $restaurant)
    {
        if (!$restaurant->is_active) {
            return ApiResponseHelper::message('The restaurant is already inactive.', 422);
        }

        $restaurant->is_active = false;
        $restaurant->save();

        return ApiResponseHelper::message('Restaurant deactivated successfully.');
    }
}
