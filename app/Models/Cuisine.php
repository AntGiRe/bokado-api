<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuisine extends Model
{
    use HasFactory;

    protected $table = 'cuisines';

    protected $fillable = [
        'code',
    ];

    public function restaurantCuisines()
    {
        return $this->hasMany(RestaurantCuisine::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_cuisines')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}
