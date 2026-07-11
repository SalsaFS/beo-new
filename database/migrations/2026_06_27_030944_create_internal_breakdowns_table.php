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
        Schema::create('internal_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_package_id')->constrained()->onDelete('cascade');
            $table->string('name',255);
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
        Schema::dropIfExists('internal_breakdowns');
    }
};
