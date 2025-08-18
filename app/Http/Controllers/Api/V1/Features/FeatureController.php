<?php

namespace App\Http\Controllers\Api\v1\Features;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use App\Helpers\ApiResponseHelper;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
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

    public function index(Request $request)
    {
        return $this->translatedIndex($request, Feature::class);
    }

    public function show($id)
    {
        return $this->translatedShow($id, Feature::class);
    }
}
