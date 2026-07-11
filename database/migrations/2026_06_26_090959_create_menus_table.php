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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_sub_type_id')->constrained()->onDelete('restrict');
            $table->foreignId('menu_code_id')->constrained()->onDelete('restrict');
            $table->foreignId('menu_type_id')->constrained()->onDelete('restrict');
            $table->string('menu_code_number', 100);
            $table->string('name', 255);
            $table->decimal('price',15,2)->nullable();
            $table->text('how_to_make')->nullable();
            $table->string('picture_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
