<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_reservation_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->boolean('is_reservations_enabled')->default(true);
            $table->integer('reservation_slot_interval')->default(30);
            $table->integer('reservation_duration')->default(60);
            $table->boolean('requires_confirmation')->default(false);
            $table->boolean('allow_cancellation')->default(true);
            $table->integer('cancellation_window')->default(60);
            $table->boolean('allow_table_selection')->default(false);
            $table->boolean('allow_zone_selection')->default(false);
            $table->boolean('allow_special_requests')->default(true);
            $table->boolean('allow_guest_count_adjustment')->default(true);
            $table->integer('guest_count_adjustment_window')->default(30);
            $table->boolean('allow_waitlist')->default(false);
            $table->integer('waitlist_notification_time')->default(15);
            $table->boolean('auto_assign_tables')->default(true);
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reservation_settings');
    }
};
