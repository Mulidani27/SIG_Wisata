<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Wisata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Tambah Data Wisata</h1>
        <form id="formWisata" action="{{ route('crud.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="Nama_Wisata" class="form-label">Nama Wisata:</label>
                <input type="text" class="form-control" id="Nama_Wisata" name="Nama_Wisata">
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi">
            </div>
            <div class="mb-3">
                <label for="Detail" class="form-label">Detail:</label>
                <textarea class="form-control" id="Detail" name="Detail"></textarea>
            </div>
            <div class="mb-3">
                <label for="Jenis_Wisata" class="form-label">Jenis Wisata:</label>
                <select class="form-select" id="Jenis_Wisata" name="Jenis_Wisata">
                    <option value="olahraga">Olahraga</option>
                    <option value="religi">Religi</option>
                    <option value="agro">Agro</option>
                    <option value="gua">Gua</option>
                    <option value="belanja">Belanja</option>
                    <option value="ekologi">Ekologi</option>
                    <option value="kuliner">Kuliner</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Gambar" class="form-label">Gambar:</label>
                <input type="text" class="form-control" id="Gambar" name="Gambar">
            </div>
            <div class="mb-3">
                <label for="gambar360" class="form-label">Gambar 360:</label>
                <input type="text" class="form-control" id="gambar360" name="gambar360">
            </div>
            <button type="button" onclick="submitForm()" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        function submitForm() {
            var lokasiInput = document.getElementById('lokasi').value;
            var lokasiArray = lokasiInput.split(',').map(parseFloat).reverse();
            document.getElementById('lokasi').value = JSON.stringify(lokasiArray);
            document.getElementById('formWisata').submit();
        }
    </script>
</body>
</html>
