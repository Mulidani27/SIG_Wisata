@extends('app')

@section('title', 'Data Wisata')

@section('content')

<div class="container">
    <h1>Tambah Data Wisata</h1>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    <!-- Tampilkan error validasi -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formWisata" action="{{ route('crud.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="Nama_Wisata" class="form-label">Nama Wisata:</label>
            <input type="text" class="form-control" id="Nama_Wisata" name="Nama_Wisata" value="{{ old('Nama_Wisata') }}">
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Koordinat:</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
            <small id="lokasiHelp" class="form-text text-muted">Masukkan Koordinat dalam format [latitude, longitude]. Misal: -3.3147664431834007, 114.59666970396356</small>
        </div>
        <div class="mb-3">
            <label for="map">Pilih Lokasi pada Peta:</label>
            <div id="map" style="height: 400px;"></div>
        </div>
        <div class="mb-3">
            <label for="Alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" id="Alamat" name="Alamat">{{ old('Alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan:</label>
            <select class="form-select" id="kecamatan" name="kecamatan">
                <option value="Banjarmasin Utara" {{ old('kecamatan') == 'Banjarmasin Utara' ? 'selected' : '' }}>Banjarmasin Utara</option>
                <option value="Banjarmasin Tengah" {{ old('kecamatan') == 'Banjarmasin Tengah' ? 'selected' : '' }}>Banjarmasin Tengah</option>
                <option value="Banjarmasin Barat" {{ old('kecamatan') == 'Banjarmasin Barat' ? 'selected' : '' }}>Banjarmasin Barat</option>
                <option value="Banjarmasin Timur" {{ old('kecamatan') == 'Banjarmasin Timur' ? 'selected' : '' }}>Banjarmasin Timur</option>
                <option value="Banjarmasin Selatan" {{ old('kecamatan') == 'Banjarmasin Selatan' ? 'selected' : '' }}>Banjarmasin Selatan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Detail" class="form-label">Detail:</label>
            <textarea class="form-control" id="Detail" name="Detail">{{ old('Detail') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="Jenis_Wisata" class="form-label">Jenis Wisata:</label>
            <select class="form-select" id="Jenis_Wisata" name="Jenis_Wisata">
                <option value="olahraga" {{ old('Jenis_Wisata') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                <option value="religi" {{ old('Jenis_Wisata') == 'religi' ? 'selected' : '' }}>Religi</option>
                <option value="agro" {{ old('Jenis_Wisata') == 'agro' ? 'selected' : '' }}>Agro</option>
                <option value="gua" {{ old('Jenis_Wisata') == 'gua' ? 'selected' : '' }}>Gua</option>
                <option value="belanja" {{ old('Jenis_Wisata') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                <option value="ekologi" {{ old('Jenis_Wisata') == 'ekologi' ? 'selected' : '' }}>Ekologi</option>
                <option value="kuliner" {{ old('Jenis_Wisata') == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
            </select>
            Olahraga,religi,agro,gua,belanja,ekologi,kuliner
        </div>
        <div class="mb-3">
            <label for="Gambar" class="form-label">Gambar:</label>
            <input type="file" class="form-control" id="Gambar" name="Gambar">
        </div>
        <div class="mb-3">
            <label for="gambar360" class="form-label">Gambar 360:</label>
            <input type="file" class="form-control" id="gambar360" name="gambar360">
        </div>
        <br>
        <br>
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

    mapboxgl.accessToken = 'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [114.59666970396356, -3.3147664431834007],
        zoom: 15
    });

    var marker = new mapboxgl.Marker({
        draggable: true
    })
    .setLngLat([114.59666970396356, -3.3147664431834007])
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
