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
}
