<?php

namespace App\Http\Controllers\Api\v1\Features;

use App\Http\Controllers\Controller;
use App\Services\Utils\TranslationFallbackService;
use App\Helpers\ApiResponseHelper;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    protected $translationService;

    public function __construct(TranslationFallbackService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index(Request $request)
    {
        $locale = $request->query('locale', app()->getLocale());
        $filter = $request->query('feature');
        $perPage = $request->query('per_page', 20);

        $query = Feature::with('translations');

        if ($filter) {
            $query->filterByNameTranslation($filter, $locale);
        }

        $paginated = $query->paginate($perPage);

        $paginated->getCollection()->transform(function ($feature) use ($locale) {
            return [
                'id' => $feature->id,
                'name' => $this->translationService->getTranslation($feature, $locale, 'name'),
            ];
        });

        return ApiResponseHelper::paginated($paginated);
    }

    public function show(Feature $feature)
    {
        $locale = app()->getLocale();

        $name = $this->translationService->getTranslation($feature, $locale, 'name');

        $data = [
            'id' => $feature->id,
            'name' => $name,
        ];

        return \App\Helpers\ApiResponseHelper::single($data);
    }
}
