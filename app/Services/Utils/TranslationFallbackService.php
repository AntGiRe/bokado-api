<?php

namespace App\Services\Utils;

class TranslationFallbackService
{
    /**
     * Obtiene la traducción para un modelo con fallback a 'en'.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model  Modelo que debe tener relación 'translations'
     * @param  string  $locale  Locale deseado
     * @param  string  $field   Campo de la traducción a devolver (por ejemplo, 'name')
     * @return string|null
     */
    public function getTranslation($model, string $locale, string $field = 'name'): ?string
    {
        if (! $model->relationLoaded('translations')) {
            $model->load('translations');
        }

        $translation = $model->translations->firstWhere('locale', $locale);

        if (! $translation) {
            $translation = $model->translations->firstWhere('locale', 'en');
        }

        return $translation?->{$field} ?? null;
    }
}
