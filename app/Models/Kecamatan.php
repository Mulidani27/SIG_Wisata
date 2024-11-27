<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table="kecamatan";

    protected $guarded=["id"];


    public function wisatas()
{
    return $this->hasMany(Wisata::class);
}

}
