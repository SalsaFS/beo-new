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
        Schema::table('beo_functions', function (Blueprint $table) {
            $table->integer('sort')->default(0)->after('banquet');
        });
    }

    public function down(): void
    {
        Schema::table('beo_functions', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
};
