<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyKecamatanColumnToForeignid extends Migration
{
    public function up(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            // Hapus kolom kecamatan lama
            $table->dropColumn('kecamatan');

            // Tambahkan kolom foreignId baru dengan default 0
            $table->foreignId('kecamatan_id')
                ->after('lokasi')
                ->default(0) // default 0 untuk kecamatan yang belum terhubung
                ->constrained('kecamatan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('wisatas', function (Blueprint $table) {
            // Hapus foreignId kecamatan_id
            $table->dropForeign(['kecamatan_id']);
            $table->dropColumn('kecamatan_id');

            // Tambahkan kembali kolom string kecamatan lama
            $table->string('kecamatan')->after('Alamat');
        });
    }
}
