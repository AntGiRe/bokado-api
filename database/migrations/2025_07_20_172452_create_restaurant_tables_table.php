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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('restaurant_zones')->onDelete('cascade');
            $table->string('name')->nullable(); // Name or number of the table
            $table->integer('capacity')->default(2); // Number of seats at the table
            $table->boolean('is_outdoor')->default(false); // Indicates if the table is outdoors
            $table->boolean('can_be_combined')->default(false); // Indicates if the table can be combined with others
            $table->boolean('is_accessible')->default(false); // Indicates if the table is accessible
            $table->integer('position_x')->nullable(); // X position for layout
            $table->integer('position_y')->nullable(); // Y position for layout
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
