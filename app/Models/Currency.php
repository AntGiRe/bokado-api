<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'symbol',
        'name',
    ];

    // Relación: una moneda puede estar asociada a muchos restaurantes
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function scopeFilterByName($query, string $filter, string $locale)
    {
        return $query->where(function ($q) use ($filter, $locale) {
            $q->where('code', 'like', "%{$filter}%")
                ->orWhere('name', 'like', "%{$filter}%")
                ->orWhereHas('translations', function ($tq) use ($filter, $locale) {
                    $tq->where('locale', $locale)
                        ->where('name', 'like', "%{$filter}%");
                });
        });
    }

    public function translations()
    {
        return $this->hasMany(CurrencyTranslation::class);
    }

    public function translation($locale = null): ?CurrencyTranslation
    {
        return $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->first();
    }

    public function getTranslatedNameAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->translations
            ->where('locale', $locale)
            ->first()?->name;
    }
}
