<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Models\Kota;
class KecamatanController extends Controller
{
    // Read (Index)
    public function index()
    {
        $kecamatans = Kecamatan::all();
        $kotas = Kota::all();
        return view('kecamatan.index', compact('kecamatans','kotas'));
    }


    public function create()
{

    $kotas = Kota::all();

    return view('kecamatan.create',compact('kotas'));
}

public function store(Request $request)
{
    $request->validate([
        'nama_kecamatan' => 'required|string|max:255',
        'kantor_kecamatan' => 'required|string|max:255',
        
    ]);

    Kecamatan::create($request->all());

    return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
}


    // Edit & Update
    public function edit($id)
{
    // Ambil data kecamatan berdasarkan ID
    $kecamatan = Kecamatan::findOrFail($id);

    // Ambil semua data kota untuk dipilih di dropdown
    $kotas = Kota::all();

    // Kembalikan data ke view 'edit' dengan mengirimkan variabel kecamatan dan kotas
    return view('kecamatan.edit', compact('kecamatan', 'kotas'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'kantor_kecamatan' => 'required|string|max:255',
        ]);

        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil diperbarui.');
    }

    // Delete
    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan berhasil dihapus.');
    }
}
