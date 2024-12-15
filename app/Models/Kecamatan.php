<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = "kecamatan";

    // Gunakan $fillable jika Anda ingin mengisi kolom secara massal
    protected $fillable = [
        'nama_kecamatan',
        'kantor_kecamatan',
        'batas_timur',
        'batas_barat',
        'batas_selatan',
        'batas_utara',
        'kota_id'
    ];

    protected $guarded = ["id"];

    /**
     * Relasi dengan model Wisata
     */
    public function wisatas()
    {
        return $this->hasMany(Wisata::class);
    }

    /**
     * Relasi dengan model Kota
     */
    public function kota()
    {
        return $this->belongsTo(Kota::class);  // Relasi ke model Kota
    }
}
