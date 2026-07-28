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
        Schema::create('beo_wedding_breakdown_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_wedding_id')->constrained()->onDelete('cascade');
            $table->string('name',255)->nullable();
            $table->integer('amount')->nullable();
            $table->decimal('rate',15,2)->nullable();
            $table->string('remark',255)->nullable();
            $table->enum('revenue_type',['hotel','room','vendor'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_wedding_breakdown_postings');
    }
};
