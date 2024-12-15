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
        Schema::table('kecamatan', function (Blueprint $table) {
            $table->string('batas_timur')->nullable();
            $table->string('batas_barat')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_utara')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();

            // Tambahkan foreign key untuk relasi dengan tabel kota
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kecamatan', function (Blueprint $table) {
            $table->dropForeign(['kota_id']);
            $table->dropColumn(['batas_timur', 'batas_barat', 'batas_selatan', 'batas_utara', 'kota_id']);
        });
    }
};
