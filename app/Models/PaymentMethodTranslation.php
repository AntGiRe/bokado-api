<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethodTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'locale',
        'name',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
