<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantCuisine extends Model
{
    use HasFactory;

    protected $table = 'restaurant_cuisines';

    protected $fillable = [
        'restaurant_id',
        'cuisine_id',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relación con Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Relación con Cuisine
    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }
}
