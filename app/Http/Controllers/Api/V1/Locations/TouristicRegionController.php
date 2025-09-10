<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesApiResources;
use App\Services\Utils\TranslationFallbackService;
use App\Models\TouristicRegion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TouristicRegionController extends Controller
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
     * Display a listing of the touristic regions.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->resourceIndex($request, TouristicRegion::class);
    }

    /**
     * Display the specified touristic region.
     */
    public function show($id): JsonResponse
    {
        return $this->resourceShow($id, TouristicRegion::class, ['cities.translations']);
    }
}
