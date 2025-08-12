<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'name',
        'description',
        'price',
        'restaurant_id',
        'contains_traces',
        'is_available',
        'is_vegetarian',
        'is_vegan',
        'is_gluten_free',
    ];

    protected $casts = [
        'contains_traces' => 'boolean',
        'is_available' => 'boolean',
        'is_vegetarian' => 'boolean',
        'is_vegan' => 'boolean',
        'is_gluten_free' => 'boolean',
    ];

    // Cada plato pertenece a un restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Relación many-to-many con categorías
    public function dishCategories()
    {
        return $this->belongsToMany(DishCategory::class, 'dish_category_dish')
                    ->withTimestamps();
    }
}
