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
        Schema::create('cuisine_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuisine_id')->constrained('cuisines')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['cuisine_id', 'locale'], 'cuisine_locale_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuisine_translations');
    }
};
