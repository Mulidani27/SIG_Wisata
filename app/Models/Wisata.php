<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_wisata');
    }
    public $timestamps = false;

    protected $fillable = [
        
        'Nama_Wisata',
        'lokasi',
        'Alamat',
        'kecamatan', 
        'Detail',
        'Jenis_Wisata',
        'Gambar',
        'gambar360',
        'gambar_lain', 
    ];
}
