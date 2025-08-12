<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProvinceTranslation extends Model
{
    protected $fillable = [
        'province_id',
        'locale',
        'name',
    ];

    /**
     * Get the province that owns the translation.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
