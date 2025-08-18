<?php

namespace App\Http\Controllers\Api\v1\Locations;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
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
        return $this->translatedIndex($request, Country::class);
    }

    public function show($id): JsonResponse
    {
        return $this->translatedShow($id, Country::class);
    }
}
