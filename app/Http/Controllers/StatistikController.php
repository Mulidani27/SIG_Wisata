<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        // Data untuk Statistik Jenis Wisata
        $jenisWisataCounts = Wisata::select('Jenis_Wisata', DB::raw('count(*) as count'))
            ->groupBy('Jenis_Wisata')
            ->get();

        // Data untuk Statistik Kecamatan menggunakan relasi
        $kecamatanCounts = Wisata::with('kecamatan')  // Load relasi kecamatan
            ->select('kecamatan_id', DB::raw('count(*) as count'))
            ->groupBy('kecamatan_id')
            ->get()
            ->map(function ($wisata) {
                return [

                    'kecamatan_id' => $wisata->kecamatan->id,  // Ambil nama kecamatan dari relasi
                    'kecamatan' => $wisata->kecamatan->nama_kecamatan,  // Ambil nama kecamatan dari relasi
                    'count' => $wisata->count
                ];
            });
           // dd($kecamatanCounts);

        // Data untuk Statistik Jenis Wisata di setiap Kecamatan
        $jenisWisataPerKecamatanRaw = Wisata::with('kecamatan')  // Load relasi kecamatan
            ->select('kecamatan_id', 'Jenis_Wisata', DB::raw('count(*) as count'))
            ->groupBy('kecamatan_id', 'Jenis_Wisata')
            ->get();

        // Format data berdasarkan kecamatan
        $jenisWisataPerKecamatan = $jenisWisataPerKecamatanRaw->groupBy('kecamatan_id');
        //dd($jenisWisataPerKecamatan);

        // Data untuk Chart.js
        $jenisWisataCountsJson = $jenisWisataCounts->pluck('count')->toArray();
        $jenisWisataLabels = $jenisWisataCounts->pluck('Jenis_Wisata')->toArray();

        $kecamatanCountsJson = $kecamatanCounts->pluck('count')->toArray();
        $kecamatanLabels = $kecamatanCounts->pluck('kecamatan')->toArray();

        return view('statistik', [
            'jenisWisataCounts' => $jenisWisataCounts,
            'kecamatanCounts' => $kecamatanCounts,
            'jenisWisataPerKecamatan' => $jenisWisataPerKecamatan,
            'jenisWisataCountsJson' => $jenisWisataCountsJson,
            'jenisWisataLabels' => $jenisWisataLabels,
            'kecamatanCountsJson' => $kecamatanCountsJson,
            'kecamatanLabels' => $kecamatanLabels,
        ]);
    }
}
