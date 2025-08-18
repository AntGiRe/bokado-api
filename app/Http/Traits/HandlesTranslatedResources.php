<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ApiResponseHelper;

trait HandlesTranslatedResources
{
    abstract protected function getTranslationService();

    public function translatedIndex(Request $request, string $modelClass)
    {
        $locale = app()->getLocale();
        $filterParam = $request->query('filter', null);
        $perPage = $request->query('per_page', 20);

        $query = $modelClass::with('translations');

        if ($filterParam) {
            $query->filterByName($filterParam, $locale);
        }

        $results = $query->paginate($perPage)->through(function (Model $item) use ($locale) {
            $item->name = $this->getTranslationService()->getTranslation($item, $locale, 'name');
            unset($item->translations);
            return $item;
        });

        return ApiResponseHelper::paginated($results);
    }

    public function translatedShow($id, string $modelClass)
    {
        $locale = app()->getLocale();

        $item = $modelClass::with('translations')->findOrFail($id);
        $item->name = $this->getTranslationService()->getTranslation($item, $locale, 'name') ?? $item->name;
        unset($item->translations);

        return ApiResponseHelper::single($item);
    }
}