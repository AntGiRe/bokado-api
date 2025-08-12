<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Services\Locations\CountryService;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService) {}

    public function index(Request $request): JsonResponse
    {
        $data = $this->countryService->getAll($request->query('country'));

        return response()->json([
            'data' => $data,
        ]);
    }

    public function show(Request $request, Country $country): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $country->id,
                'code' => $country->code,
                'name' => $country->translated_name,
            ],
        ]);
    }
}
