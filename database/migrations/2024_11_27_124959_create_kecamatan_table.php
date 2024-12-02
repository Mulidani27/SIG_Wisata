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
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kecamatan');
            $table->string('kantor_kecamatan');
            $table->string('batas_timur')->nullable(); // Tambahkan kolom batas_timur
            $table->string('batas_barat')->nullable(); // Tambahkan kolom batas_barat
            $table->string('batas_selatan')->nullable(); // Tambahkan kolom batas_selatan
            $table->string('batas_utara')->nullable(); // Tambahkan kolom batas_utara
            $table->foreignId('kota_id')->constrained('kota')->onDelete('cascade'); // Relasi ke tabel kota
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisata', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);
            $table->dropColumn('kecamatan_id');
            $table->string('kecamatan');
        });

        Schema::dropIfExists('kecamatan');
    }
};
