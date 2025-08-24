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
        Schema::create('dish_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dish_category_id')->constrained('dish_categories')->onDelete('cascade');
            $table->string('locale')->index();
            $table->foreign('locale')->references('code')->on('languages')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->unique(['dish_category_id', 'locale'], 'dish_category_locale_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_category_translations');
    }
};
