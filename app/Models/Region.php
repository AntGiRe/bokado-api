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

    /**
     * Get the translated name attribute.
     */
    public function getTranslatedNameAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->translations->where('locale', $locale)->first()?->name;
    }
}
