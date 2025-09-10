<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Http\Traits\HandlesApiResources;
use App\Services\Utils\TranslationFallbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvinceController extends Controller
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
     * Display a listing of the provinces.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->resourceIndex($request, Province::class);
    }

    /**
     * Display the specified province.
     */
    public function show($id): JsonResponse
    {
        return $this->resourceShow($id, Province::class, ['region.translations', 'region.country.translations']);
    }
}
