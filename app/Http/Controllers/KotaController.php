<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index()
    {
        $kotas = Kota::all();
        return view('kota.index', compact('kotas'));
    }

    public function create()
    {
        return view('kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota' => 'required|string|max:255',
            'kantor_kota' => 'required|string|max:255',
            'batas_timur' => 'required|string|max:255',
            'batas_barat' => 'required|string|max:255',
            'batas_selatan' => 'required|string|max:255',
            'batas_utara' => 'required|string|max:255',
        ]);

        Kota::create($request->all());

        return redirect()->route('kota.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    public function show(Kota $kota)
    {
        return view('kota.show', compact('kota'));
    }

    public function edit(Kota $kota)
    {
        return view('kota.edit', compact('kota'));
    }

    public function update(Request $request, Kota $kota)
    {
        $request->validate([
            'kota' => 'required|string|max:255',
            'kantor_kota' => 'required|string|max:255',
            'batas_timur' => 'required|string|max:255',
            'batas_barat' => 'required|string|max:255',
            'batas_selatan' => 'required|string|max:255',
            'batas_utara' => 'required|string|max:255',
        ]);

        $kota->update($request->all());

        return redirect()->route('kota.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(Kota $kota)
    {
        $kota->delete();

        return redirect()->route('kota.index')->with('success', 'Kota berhasil dihapus.');
    }
}
