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
        Schema::create('beo_wedding_additional_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_wedding_function_id')->constrained()->onDelete('cascade');
            $table->string('menu_name',255)->nullable();
            $table->integer('pax')->nullable();
            $table->decimal('rate',15,2)->nullable();
            $table->string('remark',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_wedding_additional_meals');
    }
};
