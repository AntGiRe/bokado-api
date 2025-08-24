<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristicRegionTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'touristic_region_id',
        'locale',
        'name',
        'description',
    ];

    public function touristicRegion()
    {
        return $this->belongsTo(TouristicRegion::class);
    }
}
