<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Locations\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private CityService $cityService) {}

    /**
     * Display a listing of the cities.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['region-id', 'country-id', 'province-id', 'city']);
        $cities = $this->cityService->getAllCities($filters);

        return response()->json([
            'data' => $cities->items(),
            'pagination' => [
                'current_page' => $cities->currentPage(),
                'last_page' => $cities->lastPage(),
                'per_page' => $cities->perPage(),
                'total' => $cities->total(),
            ]
        ]);
    }

    /**
     * Display the specified city.
     */
    public function show(City $city): JsonResponse
    {
        $city = $this->cityService->getCityWithRelations($city);

        return response()->json([
            'data' => $city
        ]);
    }
}
