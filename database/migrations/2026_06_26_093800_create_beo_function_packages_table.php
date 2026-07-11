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
        Schema::create('beo_function_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->constrained()->onDelete('restrict');
            $table->foreignId('setup_id')->constrained()->onDelete('restrict');
            $table->string('name',255);
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('pax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_function_packages');
    }
};
