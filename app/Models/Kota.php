<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota';

    protected $fillable = [
        'kota',
        'kantor_kota',
        'batas_timur',
        'batas_barat',
        'batas_selatan',
        'batas_utara',
    ];
}
