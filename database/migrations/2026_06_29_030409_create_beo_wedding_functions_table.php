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
        Schema::create('beo_wedding_functions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_wedding_id')->constrained()->onDelete('cascade');
            $table->foreignId('function_id')->constrained()->onDelete('restrict');
            $table->foreignId('venue_id')->constrained()->onDelete('restrict');
            $table->foreignId('setup_id')->constrained()->onDelete('restrict');
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('pax')->nullable();
            $table->text('free_meal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_wedding_functions');
    }
};
