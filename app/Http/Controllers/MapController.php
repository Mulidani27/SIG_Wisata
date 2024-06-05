<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{


    public function index ($map){
        $wisata = DB::table('wisatas')->get();
        return view('mapswisata',compact('wisata','map'));
    }
    public function viewlokasi ($lokasi){
        $wisata = DB::table('wisatas')->where("id",$lokasi)->first();
        return view ('360', compact('wisata'));
    }

}
