<?php

namespace App\Http\Controllers\Api\v1\Currency;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Http\Traits\HandlesTranslatedResources;
use App\Services\Utils\TranslationFallbackService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
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
        return $this->translatedIndex($request, Currency::class);
    }

    public function show($id)
    {
        return $this->translatedShow($id, Currency::class);
    }
}
