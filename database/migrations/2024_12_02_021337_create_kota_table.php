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
        Schema::create('kota', function (Blueprint $table) {
            $table->id();
            $table->string('kota');           // Nama kota
            $table->string('kantor_kota');    // Nama atau alamat kantor kota
            $table->string('batas_timur');    // Batas wilayah timur
            $table->string('batas_barat');    // Batas wilayah barat
            $table->string('batas_selatan');  // Batas wilayah selatan
            $table->string('batas_utara');    // Batas wilayah utara
            $table->timestamps();             // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kota');
    }
};
