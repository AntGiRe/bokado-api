<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristicRegion extends Model
{
    protected $fillable = [
        'slug',
    ];

    public array $translatable = ['name', 'description'];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_touristic_region');
    }

    public function translations()
    {
        return $this->hasMany(TouristicRegionTranslation::class);
    }

    public function translation($locale = null): ?ProvinceTranslation
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
}
