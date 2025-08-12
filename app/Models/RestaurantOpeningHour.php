<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantOpeningHour extends Model
{
    use HasFactory;

    protected $table = 'restaurant_opening_hours';

    protected $fillable = [
        'restaurant_id',
        'weekday',
        'opens_at',
        'closes_at',
    ];

    // Relación con restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getWeekdayNameAttribute()
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];
        return $days[$this->weekday] ?? 'Unknown';
    }
}
