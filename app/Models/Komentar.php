<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;



    protected $fillable = ['id_wisata', 'nama' , 'komentar', 'rating'];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}


    // public $timestamps = false;

    // protected $fillable = [
        
    //     'nama',
    //     'id_wisata',
    //     'komentar',
    //     'rating' 
    // ];
}

