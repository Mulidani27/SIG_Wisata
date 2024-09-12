<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Wisata;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    // Fungsi untuk menyimpan komentar
    public function store(Request $request, $id_wisata)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        // Menyimpan komentar ke database
        Komentar::create([
            'nama' => $request->input('nama'),
            'id_wisata' => $id_wisata,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
        ]);

        return redirect()->back()->with('success', 'Komentar dan rating berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan komentar
    public function index($id_wisata)
    {
        // Mengambil komentar berdasarkan ID Wisata
        $komentars = Komentar::where('id_wisata', $id_wisata)->get();

        // Menampilkan view dengan komentar
        return view('wisata.comments', compact('komentars'));
    }
}

