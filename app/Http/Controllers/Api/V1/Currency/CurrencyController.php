<?php

namespace App\Http\Controllers\Api\v1\Currency;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\Utils\TranslationFallbackService;
use App\Helpers\ApiResponseHelper;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected TranslationFallbackService $translationService;

    public function __construct(TranslationFallbackService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $filter = $request->query('currency');
        $perPage = $request->query('per_page', 20);

        $query = Currency::with('translations');

        if ($filter) {
            $query->filterByName($filter, $locale);
        }

        $currencies = $query->paginate($perPage)->through(function (Currency $currency) use ($locale) {
            $currency->name = $this->translationService->getTranslation($currency, $locale, 'name');
            unset($currency->translations);
            return $currency;
        });

        return ApiResponseHelper::paginated($currencies);
    }

    public function show($id)
    {
        $locale = app()->getLocale();

        $currency = Currency::with('translations')->findOrFail($id);

        $currency->name = $this->translationService->getTranslation($currency, $locale, 'name') ?? $currency->name;
        unset($currency->translations);

        return ApiResponseHelper::single($currency);
    }
}
