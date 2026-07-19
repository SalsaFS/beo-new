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
        Schema::create('client_beos', function (Blueprint $table) {
            $table->id();
            $table->string('guest_number', 100);
            $table->string('company', 255);
            $table->string('pic', 255);
            $table->text('address')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_beos');
    }
};
