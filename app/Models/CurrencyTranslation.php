<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    protected $fillable = [
        'currency_id',
        'locale',
        'name',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
