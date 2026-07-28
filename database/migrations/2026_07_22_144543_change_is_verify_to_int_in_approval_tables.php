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
        Schema::table('beo_approvals', function (Blueprint $table) {
            $table->integer('is_verify')->default(0)->change();
        });

        Schema::table('beo_wedding_approvals', function (Blueprint $table) {
            $table->integer('is_verify')->default(0)->change();
        });

        Schema::table('beo_amendment_approvals', function (Blueprint $table) {
            $table->integer('is_verify')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('beo_approvals', function (Blueprint $table) {
            $table->tinyInteger('is_verify')->default(0)->change();
        });

        Schema::table('beo_wedding_approvals', function (Blueprint $table) {
            $table->tinyInteger('is_verify')->default(0)->change();
        });

        Schema::table('beo_amendment_approvals', function (Blueprint $table) {
            $table->tinyInteger('is_verify')->default(0)->change();
        });
    }
};
