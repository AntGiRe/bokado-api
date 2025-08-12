<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantSpecialOpening extends Model
{
    use HasFactory;

    protected $table = 'restaurant_special_openings';

    protected $fillable = [
        'restaurant_id',
        'date',
        'opens_at',
        'closes_at',
        'is_closed',
    ];

    protected $casts = [
        'date' => 'date',
        'opens_at' => 'time',
        'closes_at' => 'time',
        'is_closed' => 'boolean',
    ];

    // Relación con restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
