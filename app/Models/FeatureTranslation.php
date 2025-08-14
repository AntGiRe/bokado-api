<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureTranslation extends Model
{
    protected $table = 'feature_translations';

    protected $fillable = [
        'feature_id',
        'locale',
        'name',
    ];

    /**
     * Relación con el modelo Feature.
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
