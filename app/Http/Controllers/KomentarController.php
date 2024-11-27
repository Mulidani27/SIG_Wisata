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

        return redirect()->back()->with('id_wisata', $id_wisata);
    }

    // Fungsi untuk menampilkan komentar
    public function index($id_wisata)
    {
        // Mengambil komentar berdasarkan ID Wisata
        $komentars = Komentar::where('id_wisata', $id_wisata)->get();

        // Menghitung rata-rata rating
        $averageRating = Komentar::where('id_wisata', $id_wisata)->avg('rating');

        // Menampilkan view dengan komentar dan rata-rata rating
        return view('wisata.comments', compact('komentars', 'averageRating'));
    }


    public function destroy($id)
    {
        // Temukan komentar berdasarkan ID
        $komentar = Komentar::findOrFail($id);
    
        // Simpan ID wisata untuk mengarahkan kembali setelah penghapusan
        $wisataId = $komentar->id_wisata;
    
        // Hapus komentar
        $komentar->delete();
    
        // Redirect kembali ke halaman komentar wisata yang bersangkutan
        return redirect()->route('komentar.manage', ['id' => $wisataId])->with('success', 'Komentar berhasil dihapus');
    }
    


    public function manage($id)
{
    $wisata = Wisata::findOrFail($id);
    $komentars = Komentar::where('id_wisata', $id)->get();
    return view('komentar.manage', compact('wisata', 'komentars'));
}

}
