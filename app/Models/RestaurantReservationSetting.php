<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantReservationSetting extends Model
{
    use HasFactory;

    protected $table = 'restaurant_reservation_settings';

    protected $fillable = [
        'restaurant_id',
        'is_reservations_enabled',
        'reservation_slot_interval',
        'reservation_duration',
        'requires_confirmation',
        'allow_cancellation',
        'cancellation_window',
        'allow_table_selection',
        'allow_zone_selection',
        'allow_special_requests',
        'allow_guest_count_adjustment',
        'guest_count_adjustment_window',
        'allow_waitlist',
        'waitlist_notification_time',
        'auto_assign_tables',
    ];

    protected $casts = [
        'is_reservations_enabled' => 'boolean',
        'requires_confirmation' => 'boolean',
        'allow_cancellation' => 'boolean',
        'allow_table_selection' => 'boolean',
        'allow_zone_selection' => 'boolean',
        'allow_special_requests' => 'boolean',
        'allow_guest_count_adjustment' => 'boolean',
        'allow_waitlist' => 'boolean',
        'auto_assign_tables' => 'boolean',
    ];

    // Relación con restaurante
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
