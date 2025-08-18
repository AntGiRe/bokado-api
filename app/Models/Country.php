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

    public function scopeFilterByName($query, $name, $locale)
    {
        return $query->whereHas('translations', function ($q) use ($name, $locale) {
            $q->where('locale', $locale)
                ->where('name', 'like', '%' . $name . '%');
        });
    }

}
