<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristicRegion extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_touristic_region');
    }
}
