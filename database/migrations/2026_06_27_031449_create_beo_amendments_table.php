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
        Schema::create('beo_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beo_id')->constrained()->onDelete('restrict');
            $table->string('name_of_event',255);
            $table->string('contact_person',255)->nullable();
            $table->string('contact',20)->nullable();
            $table->date('date_change')->nullable();
            $table->text('other_before')->nullable();
            $table->text('other_after')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_amendments');
    }
};
