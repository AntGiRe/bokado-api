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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
            $table->tinyInteger('food_rating')->default(0);
            $table->tinyInteger('service_rating')->default(0);
            $table->tinyInteger('ambience_rating')->default(0);

            $table->decimal('overall_rating', 3, 2)->virtualAs('ROUND((food_rating + service_rating + ambience_rating)/3, 2)');

            $table->text('comment')->nullable();
            $table->unique(['user_id', 'restaurant_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
