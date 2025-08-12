<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'description',
        'address',
        'city_id',
        'postal_code',
        'latitude',
        'longitude',
        'currency_id',
        'is_active',
        'show_prices',
        'timezone',
        'slug',
    ];

    public function generateSlug(string $name, int $id): string
    {
        $baseSlug = Str::slug($name);
        return "{$baseSlug}-r{$id}";
    }

    public function isReadyToActivate(): bool
    {
        return
            $this->restaurantPaymentMethods()->exists() &&
            $this->openingHours()->exists() &&
            $this->restaurantCuisines()->exists() &&
            $this->dishes()->exists();
    }

    public function getFullAddress(): string
    {
        $addressParts = [];

        if ($this->address) {
            $addressParts[] = $this->address;
        }

        if ($this->city) {
            $addressParts[] = $this->city->code;

            if ($this->city->province) {
                $addressParts[] = $this->city->province->code;

                if ($this->city->province->region) {
                    $addressParts[] = $this->city->province->region->code;

                    if ($this->city->province->region->country) {
                        $addressParts[] = $this->city->province->region->country->code;
                    }
                }
            }
        }

        return implode(', ', $addressParts);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function openingHours()
    {
        return $this->hasMany(RestaurantOpeningHour::class);
    }

    public function specialOpenings()
    {
        return $this->hasMany(RestaurantSpecialOpening::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'restaurant_feature')
            ->withPivot('details')
            ->withTimestamps();
    }

    public function restaurantFeatures()
    {
        return $this->hasMany(RestaurantFeature::class);
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'restaurant_payment_method')
            ->withPivot('details')
            ->withTimestamps();
    }

    public function restaurantPaymentMethods()
    {
        return $this->hasMany(RestaurantPaymentMethod::class);
    }

    public function reservationSetting()
    {
        return $this->hasOne(RestaurantReservationSetting::class);
    }

    // Para acceder a las cocinas de un restaurante (modelo pivote)
    public function restaurantCuisines()
    {
        return $this->hasMany(RestaurantCuisine::class);
    }

    // Si quieres acceder directamente a las cocinas sin el modelo pivote:
    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'restaurant_cuisines')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    // Relación con categorías de platos
    public function dishCategories()
    {
        return $this->hasMany(DishCategory::class)->orderBy('order');
    }

    // Relación con platos
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['role', 'start_date', 'end_date'])
            ->withTimestamps();
    }
}
