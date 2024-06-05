<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class CardWisata extends Controller
{
    public function index ($map){
        $wisata = DB::table('wisatas')->get();
        return view('card',compact('wisata'));
    }
}
