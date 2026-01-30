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
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pelaporan')->nullable()->after('id_kategori');
            $table->foreign('id_pelaporan')->references('id_pelaporan')->on('input_aspirasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['id_pelaporan']);
            $table->dropColumn('id_pelaporan');
        });
    }
};
