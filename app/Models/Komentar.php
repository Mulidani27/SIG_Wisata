<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'id_wisata', 'komentar', 'rating'];

    // Relasi ke model Wisata
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata');
    }
}



    // public $timestamps = false;

    // protected $fillable = [
        
    //     'nama',
    //     'id_wisata',
    //     'komentar',
    //     'rating' 
    // ];

