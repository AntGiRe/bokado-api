<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityTranslation extends Model
{
    protected $fillable = [
        'city_id',
        'locale',
        'name',
    ];

    /**
     * Get the city that owns the translation.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
