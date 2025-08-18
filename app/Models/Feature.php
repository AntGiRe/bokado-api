<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $fillable = [
        'code',
    ];

    public function restaurantFeatures()
    {
        return $this->hasMany(RestaurantFeature::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_feature')
            ->withPivot('details')
            ->withTimestamps();
    }

    public function scopeFilterByName($query, $name, $locale)
    {
        return $query->whereHas('translations', function ($q) use ($name, $locale) {
            $q->where('locale', $locale)
                ->where('name', 'like', '%' . $name . '%');
        });
    }

    public function translations()
    {
        return $this->hasMany(FeatureTranslation::class);
    }

    public function translation($locale = null)
    {
        return $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->first();
    }
}
