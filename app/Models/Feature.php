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
}
