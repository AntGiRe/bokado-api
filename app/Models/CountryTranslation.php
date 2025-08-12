<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryTranslation extends Model
{
    protected $table = 'country_translations';

    protected $fillable = [
        'country_id',
        'locale',
        'name',
    ];

    /**
     * Relación con el país original.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
