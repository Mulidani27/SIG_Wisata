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
            $table->string('kantor_kecamatan'); // Tambahkan kolom kantor_kecamatan
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisata', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']); // Hapus foreign key
            $table->dropColumn('kecamatan_id'); // Hapus kolom kecamatan_id
            $table->string('kecamatan'); // Kembalikan kolom kecamatan
        });
    }
};
