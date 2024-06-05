<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nama_Wisata',
        'lokasi',
        'Detail',
        'Jenis_Wisata',
        'Gambar',
        'gambar360', 
    ];
}
