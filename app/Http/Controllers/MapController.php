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
        $wisata = Wisata::with('komentars')->get();
        $geojsons = Geojson::all(); 
    
        $kelurahan = [ 
            'Banjarmasin Barat' => ['Basirih', 'Belitung Selatan', 'Belitung Utara', 'Kuin Cerucuk', 'Kuin Selatan', 'Pelambuan', 'Telaga Biru', 'Telawang', 'Teluk Tiram'],
            'Banjarmasin Selatan' => ['Basirih Selatan', 'Kelayan Barat', 'Kelayan Dalam', 'Kelayan Tengah', 'Kelayan Timur', 'Kelayan Selatan', 'Mantuil', 'Murung Raya', 'Pekauman', 'Pemurus Baru', 'Pemurus Dalam', 'Tanjung Pagar'],
            'Banjarmasin Tengah' => ['Antasan Besar', 'Gadang', 'Kertak Baru Ilir', 'Kertak Baru Ulu', 'Kelayan Luar', 'Mawar', 'Melayu', 'Pasar Lama', 'Pekapuran Laut', 'Seberang Mesjid', 'Sungai Baru', 'Teluk Dalam'],
            'Banjarmasin Timur' => ['Benua Anyar', 'Karang Mekar', 'Kebun Bunga', 'Kuripan', 'Pekapuran Raya', 'Pemurus Luar', 'Pengambangan', 'Sungai Bilu', 'Sungai Lulut'],
            'Banjarmasin Utara' => ['Alalak Utara', 'Alalak Tengah', 'Alalak Selatan', 'Antasan Kecil Timur', 'Kuin Utara', 'Pangeran', 'Sungai Andai', 'Sungai Jingah', 'Sungai Miai', 'Sungai Mufti']
        ];
    
        // Kelompokkan geojsons berdasarkan kecamatan
        $geojsonGrouped = $geojsons->groupBy(function($item) use ($kelurahan) {
            foreach ($kelurahan as $kecamatan => $daerahs) {
                if (in_array($item->nama_wilayah, $daerahs)) {
                    return $kecamatan;
                }
            }
        });
    
        return view('mapswisata', compact('wisata', 'map', 'geojsons', 'kelurahan', 'geojsonGrouped'));
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
