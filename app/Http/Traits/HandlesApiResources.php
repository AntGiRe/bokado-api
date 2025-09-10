<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\ApiResponseHelper;

trait HandlesApiResources
{
    abstract protected function getTranslationService();

    public function resourceIndex(Request $request, string $modelClass, array $withRelations = [], bool $withTranslation = true, bool $withTimestamps = false)
    {
        $locale = app()->getLocale();
        $perPage = $request->query('per_page', 20);

        $hasTranslations = method_exists($modelClass, 'translations');
        $relations = $withTranslation && $hasTranslations
            ? array_merge(['translations'], $withRelations)
            : $withRelations;

        $query = $modelClass::with($relations);

        foreach ($request->query() as $key => $value) {
            if (in_array($key, ['per_page', 'page'])) {
                continue;
            }

            if ($key === 'filter' && method_exists($modelClass, 'scopeFilterByName')) {
                $query->filterByName($value, $locale);
                continue;
            }

            $scopeName = 'filterBy' . ucfirst(\Illuminate\Support\Str::camel($key));
            if (method_exists($modelClass, 'scope' . ucfirst($scopeName))) {
                $query->{$scopeName}($value);
            }
        }

        $results = $query->paginate($perPage)->through(function (Model $item) use ($locale, $withTranslation, $withTimestamps) {
            if ($withTranslation) {
                $item = $this->translateNameRecursively($item, $locale, 'en');
                unset($item->translations);
            }
            if (!$withTimestamps) {
                $item = $this->removeTimestampsRecursively($item);
            }
            return $item;
        });

        return ApiResponseHelper::paginated($results);
    }

    public function resourceShow($id, string $modelClass, array $withRelations = [], bool $withTranslation = true, bool $withTimestamps = false, ?string $message = null, int $statusCode = 200)
    {
        $locale = app()->getLocale();

        $hasTranslations = method_exists($modelClass, 'translations');
        $relations = $withTranslation && $hasTranslations
            ? array_merge(['translations'], $withRelations)
            : $withRelations;

        $query = $modelClass::with($relations);
        $item = $query->findOrFail($id);

        if ($withTranslation) {
            $item = $this->translateNameRecursively($item, $locale);
            unset($item->translations);
        }

        if (!$withTimestamps) {
            $item = $this->removeTimestampsRecursively($item);
        }

        return ApiResponseHelper::single($item, $message, $statusCode);
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
