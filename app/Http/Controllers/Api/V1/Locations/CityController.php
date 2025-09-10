<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Traits\HandlesApiResources;
use App\Services\Utils\TranslationFallbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use HandlesApiResources;

    protected $translationService;

    public function __construct(TranslationFallbackService $translationService)
    {
        $this->translationService = $translationService;
    }

    protected function getTranslationService()
    {
        return $this->translationService;
    }

    /**
     * Display a listing of the cities.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->resourceIndex($request, City::class);
    }

    /**
     * Display the specified city.
     */
    public function show($id): JsonResponse
    {
        return $this->resourceShow($id, City::class, ['province.region.country.translations', 'province.region.translations', 'province.translations']);
    }
}
