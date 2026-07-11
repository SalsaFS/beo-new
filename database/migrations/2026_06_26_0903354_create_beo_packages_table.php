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
        Schema::create('beo_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('restrict');
            $table->foreignId('venue_id')->constrained()->onDelete('restrict');
            $table->foreignId('setup_id')->constrained()->onDelete('restrict');
            $table->integer('pax')->nullable();
            $table->enum('billing_type',['online','offline'])->default('online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_packages');
    }
};
