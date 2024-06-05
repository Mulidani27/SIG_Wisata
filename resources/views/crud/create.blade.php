<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Wisata</title>
</head>
<body>
    <h1>Tambah Data Wisata</h1>
    <form action="{{ route('crud.store') }}" method="POST">
        @csrf
        <label for="Nama_Wisata">Nama Wisata:</label><br>
        <input type="text" id="Nama_Wisata" name="Nama_Wisata"><br>
        <label for="lokasi">Lokasi:</label><br>
        <input type="text" id="lokasi" name="lokasi"><br>
        <label for="Detail">Detail:</label><br>
        <textarea id="Detail" name="Detail"></textarea><br>
        <label for="Jenis_Wisata">Jenis Wisata:</label><br>
        <select id="Jenis_Wisata" name="Jenis_Wisata">
            <option value="olahraga">Olahraga</option>
            <option value="religi">Religi</option>
            <option value="agro">Agro</option>
            <option value="gua">Gua</option>
            <option value="belanja">Belanja</option>
            <option value="ekologi">Ekologi</option>
            <option value="kuliner">Kuliner</option>
        </select><br>        
        <label for="Gambar">Gambar:</label><br>
        <input type="text" id="Gambar" name="Gambar"><br>
        <label for="gambar360">Gambar 360:</label><br>
        <input type="text" id="gambar360" name="gambar360"><br><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
