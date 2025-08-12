<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DishCategory extends Model
{
    use HasFactory;

    protected $table = 'dish_categories';

    protected $fillable = [
        'restaurant_id',
        'name',
        'order',
    ];

    // Cada categoría pertenece a un restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Relación many-to-many con platos
    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_category_dish')
                    ->withTimestamps();
    }
}
