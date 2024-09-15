<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Geojson;
use Illuminate\Support\Facades\DB;

class GeojsonController extends Controller
{
    // Menampilkan semua batas wilayah


    // public function tampil($map)
    // {
    //     $wisata = Wisata::all(); // Ambil data wisata yang diperlukan
    //     $geojsons = Geojson::all(); // Ambil data batas wilayah dari database
        
    //     // Debug data
    //     dd($wisata, $geojsons, $map);

    //     return view('mapswisata', compact('wisata', 'geojsons', 'map'));
    // }


    public function index()
    {
        $geojsons = Geojson::all();
        return view('geojson.index', compact('geojsons'));
      
    }

    // Mengunggah file GeoJSON baru
    public function upload(Request $request)
    {
        $request->validate([
            'namaWilayah' => 'required|string|max:255',
            'geojson' => 'required|file|mimes:json,geojson',
        ]);
    
        // Ambil nama file
        $fileName = time() . '-' . $request->file('geojson')->getClientOriginalName();
    
        // Simpan file ke folder public/uploads
        $path = $request->file('geojson')->move(public_path('uploads'), $fileName);
    
        // Simpan nama file ke database
        Geojson::create([
            'nama_wilayah' => $request->namaWilayah,
            'geojson' => $fileName, // Hanya menyimpan nama file
        ]);
    
        return redirect()->back()->with('success', 'Batas wilayah berhasil ditambahkan.');
    }
    


    // Menghapus batas wilayah
    public function delete($id)
    {
        $geojson = Geojson::findOrFail($id);
        $geojson->delete();

        return redirect()->back()->with('success', 'Batas wilayah berhasil dihapus.');
    
    }






}
