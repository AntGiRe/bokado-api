<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'province_id',
    ];

    // A city belongs to a province
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // A city can have many restaurants
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function touristicRegions()
    {
        return $this->belongsToMany(TouristicRegion::class, 'city_touristic_region');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CityTranslation::class);
    }

    public function translation($locale = null): ?CityTranslation
    {
        return $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->first();
    }

    public function getTranslatedNameAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->translations->where('locale', $locale)->first()?->name;
    }
}
