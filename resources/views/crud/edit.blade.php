<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Wisata</title>
</head>
<body>
    <h1>Edit Data Wisata</h1>
    <form action="{{ route('crud.update', $wisata->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <label for="Nama_Wisata">Nama Wisata:</label><br>
        <input type="text" id="Nama_Wisata" name="Nama_Wisata" value="{{ $wisata->Nama_Wisata }}"><br>
        <label for="lokasi">Lokasi:</label><br>
        <input type="text" id="lokasi" name="lokasi" value="{{ $wisata->lokasi }}"><br>
        <label for="Detail">Detail:</label><br>
        <textarea id="Detail" name="Detail">{{ $wisata->Detail }}</textarea><br>
        <label for="Jenis_Wisata">Jenis Wisata:</label><br>
        <input type="text" id="Jenis_Wisata" name="Jenis_Wisata" value="{{ $wisata->Jenis_Wisata }}"><br>
        <label for="Gambar">Gambar:</label><br>
        <input type="text" id="Gambar" name="Gambar" value="{{ $wisata->Gambar }}"><br>
        <label for="gambar360">Gambar 360:</label><br>
        <input type="text" id="gambar360" name="gambar360" value="{{ $wisata->gambar360 }}"><br><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
