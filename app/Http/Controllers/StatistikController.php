<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
{
    // Initialize query
    $query = Wisata::query();

    // Data for Jenis Wisata
    $jenisWisataCounts = $query->select('Jenis_Wisata', DB::raw('count(*) as count'))
        ->groupBy('Jenis_Wisata')
        ->get();

    // Data for Kecamatan
    $kecamatanCounts = Wisata::select('kecamatan', DB::raw('count(*) as count'))
        ->groupBy('kecamatan')
        ->get();

    // Data for Statistik Jumlah Tiap Jenis Wisata di Kecamatan
    $jenisWisataPerKecamatan = Wisata::select('kecamatan', 'Jenis_Wisata', DB::raw('count(*) as count'))
        ->groupBy('kecamatan', 'Jenis_Wisata')
        ->get();

    return view('statistik', [
        'jenisWisataCounts' => $jenisWisataCounts,
        'kecamatanCounts' => $kecamatanCounts,
        'jenisWisataPerKecamatan' => $jenisWisataPerKecamatan,
    ]);
}

}
