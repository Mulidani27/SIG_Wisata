<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::all();
        return view('crud.index', compact('wisata'));
    }

    public function create()
    {
        return view('crud.create');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'Nama_Wisata' => 'required',
            'lokasi' => 'required',
            'Detail' => 'required',
            'Jenis_Wisata' => 'required',
            'Gambar' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar360' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('Gambar')) {
            $gambarFile = $request->file('Gambar');
            $gambarName = Str::random(10) . '.' . $gambarFile->getClientOriginalExtension();
            $gambarFile->move(public_path('uploads'), $gambarName);
            $data['Gambar'] = $gambarName;
        }

        if ($request->hasFile('gambar360')) {
            $gambar360File = $request->file('gambar360');
            $gambar360Name = Str::random(10) . '.' . $gambar360File->getClientOriginalExtension();
            $gambar360File->move(public_path('uploads'), $gambar360Name);
            $data['gambar360'] = $gambar360Name;
        }

        $wisata = Wisata::create($data);

        if ($wisata) {
            return redirect()->route('data.show')->with('success', 'Data berhasil ditambahkan');
        } else {
            return back()->withInput()->with('failed', 'Gagal menambahkan data. Silakan coba lagi');
        }
    }

    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('crud.edit', compact('wisata'));
    }

    public function update(Request $request, string $id)
    {
        $wisata = Wisata::findOrFail($id);

        $validatedData = Validator::make($request->all(), [
            'Nama_Wisata' => 'required',
            'lokasi' => 'required',
            'Detail' => 'required',
            'Jenis_Wisata' => 'required',
            'Gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar360' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }

        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('Gambar')) {
            $gambarFile = $request->file('Gambar');
            $gambarName = Str::random(10) . '.' . $gambarFile->getClientOriginalExtension();
            $gambarFile->move(public_path('uploads'), $gambarName);
            $data['Gambar'] = $gambarName;
        }

        if ($request->hasFile('gambar360')) {
            $gambar360File = $request->file('gambar360');
            $gambar360Name = Str::random(10) . '.' . $gambar360File->getClientOriginalExtension();
            $gambar360File->move(public_path('uploads'), $gambar360Name);
            $data['gambar360'] = $gambar360Name;
        }

        $wisata->update($data);

        return redirect()->route('data.show')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);
        $deleted = $wisata->delete();

        if ($deleted) {
            return redirect()->route('data.show')->with('success', 'Data berhasil dihapus');
        } else {
            return back()->withInput()->with('failed', 'Gagal menghapus data. Silakan coba lagi');
        }
    }

    public function show($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('crud.detail', compact('wisata'));
    }
}
