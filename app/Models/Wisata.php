<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        
        'Nama_Wisata',
        'lokasi',
        'Detail',
        'Jenis_Wisata',
        'Gambar',
        'gambar360', 
    ];
}
