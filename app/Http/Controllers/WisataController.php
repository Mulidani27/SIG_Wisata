<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\Validator;

class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::all();
        return view('crud.index', compact('wisata'));
    }

    public function create()
    {
        $wisata = Wisata::all();
        return view('crud.create', compact('wisata'));
    }
    public function store(Request $request)
    {
        $wisata = Wisata::create($request->all()); // Definisikan $wisata dengan hasil create
    
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
    

    public function update(Request $request, string $id) // Updated signature
    {
        $wisata = Wisata::findOrFail($id);

        $validatedData = Validator::make($request->all(), [ // Use Validator for validation
            'Nama_Wisata' => 'required',
            'lokasi' => 'required',
            'Detail' => 'required',
            'Jenis_Wisata' => 'required',
            'Gambar' => 'required', // Update validation rules based on your model
            'gambar360' => 'required',
        ]);

        if ($validatedData->fails()) { // Handle validation errors
            return back()->withErrors($validatedData)->withInput();
        }

        $wisata->update($validatedData->validated()); // Update with validated data

        return redirect()->route('data.show')->with('success', 'Data berhasil diubah!');
        
    }


    public function createPost(Request $request) // Renamed method
    {
        $validatedData = $request->validate([
            'Nama_Wisata' => 'required', // Might need adjustments depending on Post model
            'lokasi' => 'required',
            'Detail' => 'required',
            'Jenis_Wisata' => 'required',
            'Gambar' => 'required',
            'gambar360' => 'required',
        ]);

        Post::create($validatedData);
        return redirect('/posts')->with('success', 'Post berhasil ditambahkan!');
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
