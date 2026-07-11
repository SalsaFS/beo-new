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
        Schema::create('beo_weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_wedding_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->string('event_number', 100);
            $table->date('date_of_function');
            $table->integer('guaranteed')->nullable();
            $table->integer('expected')->nullable();
            $table->text('setup_arrangements')->nullable();
            $table->text('protocol')->nullable();
            $table->string('payment_information',255)->nullable();
            $table->text('payment_note')->nullable();
            $table->text('other_note')->nullable();
            $table->text('note')->nullable();
            $table->string('signed',255)->nullable();
            $table->text('menu_list')->nullable();
            $table->decimal('deposit',15,2)->nullable();
            $table->enum('banquet',['as per chef','request','no meals'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beo_weddings');
    }
};
