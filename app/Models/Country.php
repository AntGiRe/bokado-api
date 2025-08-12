<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    // Un país tiene muchas provincias
    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    public function getTranslatedNameAttribute()
    {
        return $this->translations->where('locale', app()->getLocale())->first()?->name ?? $this->code;
    }

}
