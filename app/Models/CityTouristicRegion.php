<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityTouristicRegion extends Model
{
    protected $table = 'city_touristic_region';

    protected $fillable = [
        'city_id',
        'touristic_region_id',
    ];

    // Relaciones

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function touristicRegion()
    {
        return $this->belongsTo(TouristicRegion::class);
    }
}
