<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Wisata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Edit Data Wisata</h1>
        <form id="formWisata" action="{{ route('crud.update', $wisata->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="Nama_Wisata" class="form-label">Nama Wisata:</label>
                <input type="text" class="form-control" id="Nama_Wisata" name="Nama_Wisata" value="{{ $wisata->Nama_Wisata }}">
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ trim($wisata->lokasi, '[]') }}">
            </div>
            <div class="mb-3">
                <label for="Detail" class="form-label">Detail:</label>
                <textarea class="form-control" id="Detail" name="Detail">{{ $wisata->Detail }}</textarea>
            </div>
            <div class="mb-3">
                <label for="Jenis_Wisata" class="form-label">Jenis Wisata:</label>
                <select class="form-select" id="Jenis_Wisata" name="Jenis_Wisata">
                    <option value="olahraga" {{ $wisata->Jenis_Wisata == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="religi" {{ $wisata->Jenis_Wisata == 'religi' ? 'selected' : '' }}>Religi</option>
                    <option value="agro" {{ $wisata->Jenis_Wisata == 'agro' ? 'selected' : '' }}>Agro</option>
                    <option value="gua" {{ $wisata->Jenis_Wisata == 'gua' ? 'selected' : '' }}>Gua</option>
                    <option value="belanja" {{ $wisata->Jenis_Wisata == 'belanja' ? 'selected' : '' }}>Belanja</option>
                    <option value="ekologi" {{ $wisata->Jenis_Wisata == 'ekologi' ? 'selected' : '' }}>Ekologi</option>
                    <option value="kuliner" {{ $wisata->Jenis_Wisata == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Gambar" class="form-label">Gambar:</label>
                <input type="text" class="form-control" id="Gambar" name="Gambar" value="{{ $wisata->Gambar }}">
            </div>
            <div class="mb-3">
                <label for="gambar360" class="form-label">Gambar 360:</label>
                <input type="text" class="form-control" id="gambar360" name="gambar360" value="{{ $wisata->gambar360 }}">
            </div>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        // Fungsi untuk mengubah format lokasi sebelum submit
        function submitForm() {
            var lokasiInput = document.getElementById('lokasi').value; // Mendapatkan nilai input lokasi
            var lokasiArray = lokasiInput.split(',').map(parseFloat).reverse(); // Memisahkan nilai lokasi dan mengonversi menjadi float, lalu membalikkan urutannya
            var formattedLokasi = '[' + lokasiArray.join(', ') + ']'; // Mengubah nilai lokasi menjadi string dengan pemisah koma dan spasi, ditambah tanda kurung siku
            document.getElementById('lokasi').value = formattedLokasi; // Memperbarui nilai input lokasi
            document.getElementById('formWisata').submit(); // Mengirimkan form
        }
    </script>


</body>

</html>