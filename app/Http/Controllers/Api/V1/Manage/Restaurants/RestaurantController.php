<?php

namespace App\Http\Controllers\Api\v1\Manage\Restaurants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\StoreRestaurantRequest;
use App\Http\Requests\Manage\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Services\Manage\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function __construct(private RestaurantService $restaurantService){}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $restaurants = $user->restaurants()
            ->with('city')
            ->get();

        return response()->json([
            'data' => $restaurants
        ]);
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

        $restaurant = $this->restaurantService->createWithOwner($validated, $request->user());

        return response()->json([
            'message' => 'Restaurant created successfully',
            'data' => $restaurant
        ], 201);
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

        $this->restaurantService->update($restaurant, $validated);

        return response()->json([
            'message' => 'Restaurant updated successfully',
            'data' => $restaurant
        ]);
    }

    /**
     * Display the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Restaurant $restaurant)
    {
        return response()->json([
            'message' => 'Restaurant retrieved successfully',
            'data' => $restaurant
        ]);
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

        return response()->json([
            'message' => 'Restaurant deleted successfully'
        ]);
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
            return response()->json([
                'message' => 'Missing required settings to activate the restaurant.'
            ], 422);
        }

        $restaurant->is_active = true;
        $restaurant->save();

        return response()->json(['message' => 'Restaurant activated successfully.']);
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
            return response()->json(['message' => 'Restaurant is already inactive.'], 422);
        }

        $restaurant->is_active = false;
        $restaurant->save();

        return response()->json(['message' => 'Restaurante desactivado con éxito.']);
    }
}
