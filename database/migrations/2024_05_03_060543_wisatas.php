<?php

use App\Models\Kecamatan;
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
        Schema::create('wisata', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Wisata');
            $table->string('lokasi');
            $table->text('Alamat');
            $table->foreignId('kecamatan')->constrained("kecamatan");
            $table->text('Detail');
            $table->enum('Jenis_Wisata', ['olahraga', 'religi', 'agro', 'gua', 'belanja', 'ekologi', 'kuliner']);
            $table->string('Gambar');
            $table->string('gambar360');
            $table->json('gambar_lain')->nullable(); // Menambahkan kolom gambar_lain untuk menyimpan banyak gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};
