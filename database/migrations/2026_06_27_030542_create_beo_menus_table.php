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
        Schema::create('beo_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_function_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('restrict');
            $table->integer('pax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_menus');
    }
};
