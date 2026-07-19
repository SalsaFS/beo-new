<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beo_function_packages', function (Blueprint $table) {
            $table->dropForeign(['beo_package_id']);
            $table->dropColumn('beo_package_id');

            $table->foreignId('beo_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('beo_function_packages', function (Blueprint $table) {
            $table->dropForeign(['beo_id']);
            $table->dropColumn('beo_id');

            $table->foreignId('beo_package_id')->constrained()->onDelete('cascade');
        });
    }
};
