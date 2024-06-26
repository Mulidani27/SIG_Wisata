 @extends('app')

@section('title', 'Data Wisata')

@section('content')

<div class="container">
    <h1>Edit Data Wisata</h1>
    <form id="formWisata" action="{{ route('crud.update', $wisata->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="Nama_Wisata" class="form-label">Nama Wisata:</label>
            <input type="text" class="form-control" id="Nama_Wisata" name="Nama_Wisata" value="{{ $wisata->Nama_Wisata }}">
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Koordinat:</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Tambahkan jika ingin merubah lokasi">
            <small id="lokasiHelp" class="form-text text-muted">Masukkan Koordinat dalam format [latitude, longitude]. Misal: -3.3147664431834007, 114.59666970396356</small>
        </div>
        <div class="mb-3">
            <label for="map">Pilih Lokasi pada Peta:</label>
            <div id="map" style="height: 400px;"></div>
        </div>
        <div class="mb-3">
            <label for="Alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" id="Alamat" name="Alamat">{{ $wisata->Alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan:</label>
            <select class="form-select" id="kecamatan" name="kecamatan">
                <option value="Banjarasin Utara" {{ old('kecamatan', $wisata->kecamatan) == 'Banjarasin Utara' ? 'selected' : '' }}>Banjarasin Utara</option>
                <option value="Banjarasin Tengah" {{ old('kecamatan', $wisata->kecamatan) == 'Banjarasin Tengah' ? 'selected' : '' }}>Banjarasin Tengah</option>
                <option value="Banjarasin Barat" {{ old('kecamatan', $wisata->kecamatan) == 'Banjarasin Barat' ? 'selected' : '' }}>Banjarasin Barat</option>
                <option value="Banjarasin Timur" {{ old('kecamatan', $wisata->kecamatan) == 'Banjarasin Timur' ? 'selected' : '' }}>Banjarasin Timur</option>
                <option value="Banjarasin Selatan" {{ old('kecamatan', $wisata->kecamatan) == 'Banjarasin Selatan' ? 'selected' : '' }}>Banjarasin Selatan</option>
            </select>
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
            <input type="file" class="form-control" id="Gambar" name="Gambar">
            <img src="{{ asset('uploads/' . $wisata->Gambar) }}" alt="{{ $wisata->Nama_Wisata }}" style="max-width: 100px; max-height: 100px;">
        </div>
        <div class="mb-3">
            <label for="gambar360" class="form-label">Gambar 360:</label>
            <input type="file" class="form-control" id="gambar360" name="gambar360">
            <img src="{{ asset('uploads/' . $wisata->gambar360) }}" alt="{{ $wisata->Nama_Wisata }}" style="max-width: 100px; max-height: 100px;">
        </div>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
    </form>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JavaScript -->
<script>
    function submitForm() {
        var lokasiInput = document.getElementById('lokasi').value.trim(); // Mendapatkan nilai input lokasi dan menghapus spasi di awal dan akhir
        if (lokasiInput) { // Memeriksa apakah lokasi tidak kosong
            var lokasiArray = lokasiInput.split(',').map(parseFloat); // Memisahkan nilai lokasi dan mengonversi menjadi float
            if (lokasiArray.length == 2 && !isNaN(lokasiArray[0]) && !isNaN(lokasiArray[1])) { // Memeriksa apakah lokasi valid
                var sortedLokasiArray = [lokasiArray[1], lokasiArray[0]]; // Mengurutkan nilai koordinat dengan benar
                var formattedLokasi = '[' + sortedLokasiArray.join(', ') + ']'; // Mengubah nilai lokasi menjadi string dengan pemisah koma dan spasi, ditambah tanda kurung siku
                document.getElementById('lokasi').value = formattedLokasi; // Memperbarui nilai input lokasi
            } else {
                alert('Format lokasi tidak valid. Pastikan formatnya adalah [latitude, longitude].');
                return false; // Jangan submit form jika lokasi tidak valid
            }
        } else {
            // Lokasi kosong, tetap gunakan nilai sebelumnya
            var previousLocation = '{{ $wisata->lokasi }}'; // Ambil data lokasi sebelumnya dari blade
            document.getElementById('lokasi').value = previousLocation; // Gunakan nilai lokasi sebelumnya
        }
        document.getElementById('formWisata').submit(); // Mengirimkan form
    }
        
    mapboxgl.accessToken = 'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', // Ganti dengan gaya peta yang Anda inginkan
        center: [114.59666970396356, -3.3147664431834007], // Koordinat default
        zoom: 15 // Zoom level default
    });

    var marker = new mapboxgl.Marker({
        draggable: true
    })
    .setLngLat([114.59666970396356, -3.3147664431834007]) // Koordinat default
    .addTo(map);

    function onDragEnd() {
        var lngLat = marker.getLngLat();
        updateInputField(lngLat.lng, lngLat.lat);
    }

    function updateInputField(lng, lat) {
        document.getElementById('lokasi').value = lat.toFixed(7) + ',' + lng.toFixed(7);
    }

    marker.on('dragend', onDragEnd);

    map.on('click', function(e) {
        marker.setLngLat(e.lngLat).addTo(map);
        onDragEnd();
    });
</script>

@endsection