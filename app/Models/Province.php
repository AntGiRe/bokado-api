<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'region_id',
    ];

    // Una provincia pertenece a una región
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Una provincia tiene muchas ciudades
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the translations for the province.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ProvinceTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation($locale = null): ?ProvinceTranslation
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
