<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Str;

trait HandlesTranslatedResources
{
    abstract protected function getTranslationService();

    public function translatedIndex(Request $request, string $modelClass, bool $withTimestamps = false)
    {
        $locale = app()->getLocale();
        $perPage = $request->query('per_page', 20);

        $query = $modelClass::with('translations');

        foreach ($request->query() as $key => $value) {
            // Evita campos que no son filtros
            if (in_array($key, ['per_page', 'page'])) {
                continue;
            }

            // Ejemplo: filter => scopeFilterByName
            if ($key === 'filter') {
                if (method_exists($modelClass, 'scopeFilterByName')) {
                    $query->filterByName($value, $locale);
                }
                continue;
            }

            // Genera nombre del scope dinámicamente, ej: countryId => filterByCountryId
            $scopeName = 'filterBy' . ucfirst(Str::camel($key));
            if (method_exists($modelClass, 'scope' . ucfirst($scopeName))) {
                $query->{$scopeName}($value);
            }
        }

        $results = $query->paginate($perPage)->through(function (Model $item) use ($locale, $withTimestamps) {
            $item = $this->translateNameRecursively($item, $locale, 'en');
            unset($item->translations);
            if (!$withTimestamps) {
                unset($item->created_at, $item->updated_at);
            }
            return $item;
        });

        return ApiResponseHelper::paginated($results);
    }

    public function translatedShow($id, string $modelClass, array $withRelations = [], bool $withTimestamps = false)
    {
        $locale = app()->getLocale();

        $query = $modelClass::with(array_merge(['translations'], $withRelations));
        $item = $query->findOrFail($id);

        $item = $this->translateNameRecursively($item, $locale);
        unset($item->translations);

        if (!$withTimestamps) {
            $item = $this->removeTimestampsRecursively($item);
        }

        return ApiResponseHelper::single($item);
    }

    protected function removeTimestampsRecursively($model)
    {
        if ($model instanceof Model) {
            unset($model->created_at, $model->updated_at);

            foreach ($model->getRelations() as $relation => $related) {
                $model->setRelation($relation, $this->removeTimestampsRecursively($related));
            }
        } elseif ($model instanceof Collection || is_array($model)) {
            foreach ($model as $key => $value) {
                $model[$key] = $this->removeTimestampsRecursively($value);
            }
        }

        return $model;
    }

    protected function translateNameRecursively($model, $locale, $fallbackLocale = 'en')
    {
        if ($model instanceof Model) {
            if ($model->relationLoaded('translations')) {
                $fields = property_exists($model, 'translatable') ? $model->translatable : ['name'];

                foreach ($fields as $field) {
                    $translation = $this->getTranslationService()->getTranslation($model, $locale, $field)
                        ?? ($fallbackLocale !== $locale
                            ? $this->getTranslationService()->getTranslation($model, $fallbackLocale, $field)
                            : null);

                    if ($translation !== null) {
                        $model->$field = $translation;
                    }
                }

                unset($model->translations);
            }

            foreach ($model->getRelations() as $relation => $related) {
                $model->setRelation($relation, $this->translateNameRecursively($related, $locale, $fallbackLocale));
            }
        } elseif ($model instanceof Collection || is_array($model)) {
            foreach ($model as $key => $value) {
                $model[$key] = $this->translateNameRecursively($value, $locale, $fallbackLocale);
            }
        }

        return $model;
    }
}
