<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use HandlesTranslatedResources;

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
        return $this->translatedIndex($request, City::class);
    }

    /**
     * Display the specified city.
     */
    public function show($id): JsonResponse
    {
        return $this->translatedShow($id, City::class, ['province.region.country.translations', 'province.region.translations', 'province.translations']);
    }
}
