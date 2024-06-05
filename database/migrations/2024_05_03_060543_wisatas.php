<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

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
            $table->text('Detail');
            $table->enum('Jenis_Wisata', ['olahraga', 'religi', 'agro', 'gua', 'belanja', 'ekologi', 'kuliner']);
            $table->string('Gambar');
            $table->string('gambar360');

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
