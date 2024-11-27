<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    public function kecamatan()
{
    return $this->belongsTo(Kecamatan::class);
}


    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_wisata');
    }
    public $timestamps = false;

    protected $fillable = [
        
        'Nama_Wisata',
        'lokasi',
        'Alamat',
        'kecamatan_id', 
        'Detail',
        'Jenis_Wisata',
        'Gambar',
        'gambar360',
        'gambar_lain', 
    ];
}
