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
        Schema::create('restaurant_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->string('url');
            $table->string('alt_text')->nullable(); // Optional alt text for the photo
            $table->boolean('is_cover')->default(false); // Indicates if this photo is the cover photo
            $table->boolean('is_active')->default(true); // Indicates if the photo is active
            $table->integer('order')->default(0); // Order of the photo in the gallery
            $table->foreignId('dish_id')->nullable()->constrained('dishes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_photos');
    }
};
