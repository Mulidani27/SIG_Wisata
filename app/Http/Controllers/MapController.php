<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\Geojson;
use App\Models\Komentar;

class MapController extends Controller
{
    public function index($map)
    {
        // Menggunakan Eloquent untuk mengambil data wisata beserta komentarnya
        $wisata = Wisata::with('komentars')->get();
        $geojsons = Geojson::all(); 
        

        return view('mapswisata', compact('wisata', 'map', 'geojsons'));
    }
    
    public function viewlokasi($lokasi)
    {
        // Menggunakan Eloquent untuk mengambil satu data wisata
        $wisata = Wisata::with('komentars')->where('id', $lokasi)->firstOrFail();
        return view('360', compact('wisata'));
    }

    public function view($id)
    {
        // Menggunakan Eloquent agar bisa memuat relasi komentars
        $wisata = Wisata::with('komentars')->findOrFail($id);
        return view('mapswisata', compact('wisata')); 
    }


    
}
