<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantPaymentMethod extends Model
{
    protected $table = 'restaurant_payment_method';

    protected $fillable = [
        'restaurant_id',
        'payment_method_id'
    ];

    /**
     * Relación con el restaurante.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relación con el método de pago.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
