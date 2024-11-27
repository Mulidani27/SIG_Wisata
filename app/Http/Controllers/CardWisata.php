<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wisata;

class CardWisata extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        
        // Mengambil data wisata berdasarkan pencarian dan memuat relasi kecamatan
        $wisata = Wisata::with('kecamatan') // Memuat relasi kecamatan
                    ->when($searchQuery, function($query) use ($searchQuery) {
                        return $query->where('Nama_Wisata', 'like', '%' . $searchQuery . '%');
                    })
                    ->get();

        return view('card', compact('wisata'));
    }
}
