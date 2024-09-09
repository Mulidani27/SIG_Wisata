<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardWisata extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        
        // Mengambil data wisata berdasarkan pencarian
        $wisata = DB::table('wisatas')
                    ->when($searchQuery, function($query) use ($searchQuery) {
                        return $query->where('Nama_Wisata', 'like', '%' . $searchQuery . '%');
                    })
                    ->get();

        return view('card', compact('wisata'));
    }
}
