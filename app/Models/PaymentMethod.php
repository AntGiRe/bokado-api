<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = [
        'code',
        'is_active',
    ];

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->translations->where('locale', $locale)->first()?->name;
    }

    public function restaurantPaymentMethods()
    {
        return $this->hasMany(RestaurantPaymentMethod::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_payment_method')
            ->withPivot('details')
            ->withTimestamps();
    }

    public function translations()
    {
        return $this->hasMany(PaymentMethodTranslation::class);
    }

    public function translation($locale = null)
    {
        return $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->first();
    }
}
