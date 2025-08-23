<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'code',
        'country_id',
    ];

    // Una región puede tener muchas provincias
    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    // Una región pertenece a un país
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the translations for the region.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(RegionTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation($locale = null): ?RegionTranslation
    {
        return $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->first();
    }

    public function scopeFilterByName($query, $name, $locale)
    {
        return $query->whereHas('translations', function ($q) use ($name, $locale) {
            $q->where('locale', $locale)
                ->where('name', 'like', "%$name%");
        });
    }

    public function scopeFilterByCountryId($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }
}
