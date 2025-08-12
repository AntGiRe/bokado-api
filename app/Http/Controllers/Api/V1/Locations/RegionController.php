<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use App\Services\Locations\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(private RegionService $regionService) {}

    /**
     * Display a listing of the regions.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['country-id', 'region']);
        $regions = $this->regionService->getAllRegions($filters);

        return response()->json([
            'data' => $regions->items(),
            'pagination' => [
                'current_page' => $regions->currentPage(),
                'last_page' => $regions->lastPage(),
                'per_page' => $regions->perPage(),
                'total' => $regions->total(),
            ]
        ]);
    }

    /**
     * Display the specified region.
     */
    public function show(Region $region): JsonResponse
    {
        $region = $this->regionService->getRegionWithRelations($region);

        return response()->json([
            'data' => $region
        ]);
    }
}
