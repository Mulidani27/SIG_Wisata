<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function index()
    {
        $komentars = Komentar::all();
        return view('komentar', compact('komentars'));
    }

    

    public function kirimKomentar(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'nama' => 'required',
            'komentar' => 'required',
        ]);

        // Simpan komentar ke dalam database
        Komentar::create([
            'nama' => $request->nama,
            'komentar' => $request->komentar,
        ]);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
