<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use App\Models\TouristicRegion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TouristicRegionController extends Controller
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
     * Display a listing of the touristic regions.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->translatedIndex($request, TouristicRegion::class);
    }

    /**
     * Display the specified touristic region.
     */
    public function show($id): JsonResponse
    {
        return $this->translatedShow($id, TouristicRegion::class, ['cities.translations']);
    }
}
