<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantFeature extends Model
{
    protected $table = 'restaurant_feature';

    protected $fillable = [
        'restaurant_id',
        'feature_id',
        'details',
    ];

    /**
     * Relación con el restaurante.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relación con la característica.
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
