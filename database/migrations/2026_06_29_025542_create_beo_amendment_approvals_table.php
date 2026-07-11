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
        Schema::create('beo_amendment_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_amendment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->tinyInteger('is_verify')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_amendment_approvals');
    }
};
