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
        Schema::create('allergen_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allergen_id')->constrained('allergens')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['allergen_id', 'locale'], 'allergen_locale_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergen_translations');
    }
};
