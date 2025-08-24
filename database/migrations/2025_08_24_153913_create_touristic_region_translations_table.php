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
        Schema::create('touristic_region_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('touristic_region_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->foreign('locale')->references('code')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['touristic_region_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('touristic_region_translations');
    }
};
