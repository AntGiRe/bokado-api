<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use Illuminate\Http\Request;

class RegionController extends Controller
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

    public function index(Request $request): JsonResponse
    {
        return $this->translatedIndex($request, Region::class);
    }

    /**
     * Display the specified region.
     */
    public function show($id): JsonResponse
    {
        return $this->translatedShow($id, Region::class, ['country.translations']);
    }
}
