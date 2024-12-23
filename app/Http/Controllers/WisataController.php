<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Kecamatan;


class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::all();
        // dd($wisata);
        return view('crud.index', compact('wisata' ));

    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        return view('crud.create', compact('kecamatans'));

        
        
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'Nama_Wisata' => 'nullable',
            'latitut_longitut' => 'nullable',
            'Alamat' => 'nullable',
            'kecamatan' => 'nullable',
            'Detail' => 'nullable',
            'Jenis_Wisata' => 'nullable',
            'Gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'gambar360' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'gambar_lain' => 'nullable|array',
            'gambar_lain.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
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
            $gambar360Name = Str::random(length: 10) . '.' . $gambar360File->getClientOriginalExtension();
            $gambar360File->move(public_path('uploads'), $gambar360Name);
            $data['gambar360'] = $gambar360Name;
        }

        // Handle gambar_lain
        if ($request->hasFile('gambar_lain')) {
            $gambarLain = $request->file('gambar_lain');
            $uploadedImages = [];

            foreach ($gambarLain as $gambar) {
                $gambarName = Str::random(10) . '.' . $gambar->getClientOriginalExtension();
                $gambar->move(public_path('uploads/gambar_lain'), $gambarName);
                $uploadedImages[] = $gambarName;
            }

            // Simpan gambar_lain dalam bentuk JSON
            $data['gambar_lain'] = json_encode($uploadedImages);
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
        // Ambil data wisata berdasarkan ID
        $wisata = Wisata::findOrFail($id);
    
        // Ambil semua data kecamatan
        $kecamatans = Kecamatan::all();
    
        // Kirim data wisata dan kecamatan ke view
        return view('crud.edit', compact('wisata', 'kecamatans'));
    }
    

    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);
    
        $validatedData = Validator::make($request->all(), [
            'Nama_Wisata' => 'nullable',
            'latitut_longitut' => 'nullable',
            'Alamat' => 'nullable',
            'kecamatan' => 'nullable',
            'Detail' => 'nullable',
            'Jenis_Wisata' => 'nullable',
            'Gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'gambar360' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'gambar_lain' => 'nullable|array',
            'gambar_lain.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_gambar_lain' => 'nullable|array',
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
    

        if ($request->hasFile('gambar_lain')) {
            $gambarLain = $request->file('gambar_lain');
            $uploadedImages = [];

            foreach ($gambarLain as $gambar) {
                $gambarName = Str::random(10) . '.' . $gambar->getClientOriginalExtension();
                $gambar->move(public_path('uploads/gambar_lain'), $gambarName);
                $uploadedImages[] = $gambarName;
            }

            // Gabungkan gambar_lain yang sudah ada dengan yang baru diupload
            $existingImages = json_decode($wisata->gambar_lain, true) ?? [];
            $data['gambar_lain'] = json_encode(array_merge($existingImages, $uploadedImages));
        }

        // Update data wisata dengan data baru
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

    public function uploadGambar(Request $request, $id)
    {
        // Validasi gambar
        $request->validate([
            'gambar_lain.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        // Ambil data wisata berdasarkan ID
        $wisata = Wisata::findOrFail($id);
    
        // Cek apakah gambar_lain sudah ada sebelumnya
        $gambarLain = $wisata->gambar_lain ? json_decode($wisata->gambar_lain, true) : [];
    
        // Proses gambar yang diunggah
        if ($request->hasFile('gambar_lain')) {
            foreach ($request->file('gambar_lain') as $file) {
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/gambar_lain'), $namaFile);
                $gambarLain[] = $namaFile;  // Tambahkan nama file ke array
            }
        }
    
        // Update kolom gambar_lain
        $wisata->gambar_lain = json_encode($gambarLain);
        $wisata->save();
    
        return redirect()->back()->with('success', 'Gambar berhasil diunggah!');
    }
    public function deleteSingleGambarLain(Request $request, $id)
    {
        // Ambil data wisata berdasarkan ID
        $wisata = Wisata::findOrFail($id);
        
        // Ambil gambar_lain yang sudah ada
        $gambarLain = json_decode($wisata->gambar_lain, true) ?? [];
    
        // Ambil gambar yang akan dihapus dari request
        $gambarYangHapus = $request->gambar;
    
        // Temukan dan hapus gambar dari array
        if (($key = array_search($gambarYangHapus, $gambarLain)) !== false) {
            unset($gambarLain[$key]);
    
            // Hapus gambar dari storage
            $filePath = public_path('uploads/gambar_lain/' . $gambarYangHapus);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    
        // Update kolom gambar_lain
        $wisata->gambar_lain = json_encode(array_values($gambarLain));
        $wisata->save();
    
        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus!']);
    }
    

    
}
