<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Services\Locations\ProvinceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct(private ProvinceService $provinceService) {}

    /**
     * Display a listing of the provinces.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['region-id', 'country-id', 'province']);
        $provinces = $this->provinceService->getAllProvinces($filters);

        return response()->json([
        'data' => $provinces->items(), // Solo los datos
        'pagination' => [
            'current_page' => $provinces->currentPage(),
            'last_page' => $provinces->lastPage(),
            'per_page' => $provinces->perPage(),
            'total' => $provinces->total(),
        ]
    ]);
    }

    /**
     * Display the specified province.
     */
    public function show(Province $province): JsonResponse
    {
        $province = $this->provinceService->getProvinceWithRelations($province);

        return response()->json([
            'data' => $province
        ]);
    }
}
