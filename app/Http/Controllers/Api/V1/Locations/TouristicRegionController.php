<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Services\Locations\TouristicRegionService;
use App\Models\TouristicRegion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TouristicRegionController extends Controller
{
    public function __construct(private TouristicRegionService $touristicRegionService) {}

    /**
     * Display a listing of the touristic regions.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['touristic_region']);
        $touristicRegions = $this->touristicRegionService->getAllTouristicRegions($filters);

        return response()->json([
            'data' => $touristicRegions->items(),
            'pagination' => [
                'current_page' => $touristicRegions->currentPage(),
                'last_page' => $touristicRegions->lastPage(),
                'per_page' => $touristicRegions->perPage(),
                'total' => $touristicRegions->total(),
            ]
        ]);
    }

    /**
     * Display the specified touristic region.
     */
    public function show(TouristicRegion $touristicRegion): JsonResponse
    {
        $touristicRegion = $this->touristicRegionService->getTouristicRegionWithRelations($touristicRegion);

        return response()->json([
            'data' => $touristicRegion
        ]);
    }
}
