<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    // Read (Index)
    public function index()
    {
        $kecamatans = Kecamatan::all();
        return view('kecamatan.index', compact('kecamatans'));
    }


    public function create()
{
    return view('kecamatan.create');
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
        $kecamatan = Kecamatan::findOrFail($id);
        return view('kecamatan.edit', compact('kecamatan'));
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
