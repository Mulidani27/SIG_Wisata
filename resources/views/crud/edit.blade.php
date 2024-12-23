@extends('app')

@section('title', 'Data Wisata')

@section('content')

    <div class="container">
        <h1>Edit Data Wisata</h1>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: "success",
                    title: "berhasilll",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            </script>
        @endif

        @if (session('failed'))
            <script>
                Swal.fire({
                    icon: "error",
                    title: "gagalll",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            </script>
        @endif

        <form id="formWisata" action="{{ route('crud.update', $wisata->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="Nama_Wisata" class="form-label">Nama Wisata:</label>
                <input type="text" class="form-control" id="Nama_Wisata" name="Nama_Wisata"
                    value="{{ $wisata->Nama_Wisata }}">
            </div>
            <div class="mb-3">
                <label for="latitut_longitut" class="form-label">Koordinat:</label>
                <input type="text" class="form-control" id="latitut_longitut" name="latitut_longitut"
                    placeholder="Tambahkan jika ingin merubah lokasi">
                <small id="lokasiHelp" class="form-text text-muted">Masukkan Koordinat dalam format [latitude, longitude].
                    Misal: -3.3147664431834007, 114.59666970396356</small>
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
                <select class="form-select" id="kecamatan" name="kecamatan_id">
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" 
                            {{ (old('kecamatan_id', $wisata->kecamatan_id) == $kecamatan->id) ? 'selected' : '' }}>
                            {{ $kecamatan->nama_kecamatan }}
                        </option>
                    @endforeach
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
                <br>
                <img src="{{ asset('uploads/' . $wisata->Gambar) }}" alt="{{ $wisata->Nama_Wisata }}"
                    style="max-width: 100px; max-height: 100px;">
            </div>
            <div class="mb-3">
                <label for="gambar360" class="form-label">Gambar 360:</label>
                <input type="file" class="form-control" id="gambar360" name="gambar360">
                <br>
                <img src="{{ asset('uploads/' . $wisata->gambar360) }}" alt="{{ $wisata->Nama_Wisata }}"
                    style="max-width: 100px; max-height: 100px;">
            </div>

            <!-- Tambah Gambar Section -->
            <div class="tambah-gambar mt-5">
                <h4 class="fw-bold">Tambah Gambar</h4>
                <form action="{{ route('wisata.uploadGambar', $wisata->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="gambar_lain" class="form-label">Pilih Gambar</label>
                        <input type="file" name="gambar_lain[]" id="gambar_lain" class="form-control" multiple required>
                    </div>
                </form>
            </div>

            <div class="mb-3">
                <h5>Gambar Lain:</h5>
                @if ($wisata->gambar_lain)
                    @php $gambarLain = json_decode($wisata->gambar_lain, true); @endphp
                    @foreach ($gambarLain as $gambar)
                        <div class="d-flex align-items-center mb-2" id="gambar-{{ $loop->index }}">
                            <img src="{{ asset('uploads/gambar_lain/' . $gambar) }}" alt="{{ $wisata->Nama_Wisata }}"
                                style="max-width: 100px; max-height: 100px; margin-right: 10px;">
                            <button class="btn btn-danger btn-sm"
                                onclick="hapusGambar('{{ $gambar }}', {{ $wisata->id }}, {{ $loop->index }})">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    @endforeach
                @else
                    <p>Tidak ada gambar lain yang tersedia.</p>
                @endif
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            
            <script>
                function hapusGambar(gambar, wisataId, index) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Gambar ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('/wisata/' + wisataId + '/delete-single-gambar-lain', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        gambar: gambar
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Hapus elemen gambar dari DOM tanpa alert tambahan
                                        document.getElementById('gambar-' + index).remove();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: 'Gambar telah berhasil dihapus.',
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: 'Terjadi kesalahan saat menghapus gambar!',
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan saat menghapus gambar!',
                                    });
                                });
                        }
                    })
                }
            </script>
                        <br>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan</button>
        </form>
    </div>















    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        function submitForm() {
            var lokasiInput = document.getElementById('latitut_longitut').value
        .trim(); // Mendapatkan nilai input lokasi dan menghapus spasi di awal dan akhir
            if (lokasiInput) { // Memeriksa apakah lokasi tidak kosong
                var lokasiArray = lokasiInput.split(',').map(
                parseFloat); // Memisahkan nilai lokasi dan mengonversi menjadi float
                if (lokasiArray.length == 2 && !isNaN(lokasiArray[0]) && !isNaN(lokasiArray[
                    1])) { // Memeriksa apakah lokasi valid
                    var sortedLokasiArray = [lokasiArray[1], lokasiArray[0]]; // Mengurutkan nilai koordinat dengan benar
                    var formattedLokasi = '[' + sortedLokasiArray.join(', ') +
                    ']'; // Mengubah nilai lokasi menjadi string dengan pemisah koma dan spasi, ditambah tanda kurung siku
                    document.getElementById('latitut_longitut').value = formattedLokasi; // Memperbarui nilai input lokasi
                } else {
                    alert('Format lokasi tidak valid. Pastikan formatnya adalah [latitude, longitude].');
                    return false; // Jangan submit form jika lokasi tidak valid
                }
            } else {
                // Lokasi kosong, tetap gunakan nilai sebelumnya
                var previousLocation = '{{ $wisata->latitut_longitut }}'; // Ambil data lokasi sebelumnya dari blade
                document.getElementById('latitut_longitut').value = previousLocation; // Gunakan nilai lokasi sebelumnya
            }
            document.getElementById('formWisata').submit(); // Mengirimkan form
        }

        mapboxgl.accessToken =
            'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [114.59666970396356, -3.3147664431834007],
            zoom: 12
        });

        var marker = new mapboxgl.Marker({
                draggable: true
            })
            .setLngLat([114.59666970396356, -3.3147664431834007]) // Koordinat marker
            .addTo(map);

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            document.getElementById('latitut_longitut').value = lngLat.lat + ', ' + lngLat
            .lng; // Memperbarui input lokasi dengan koordinat yang baru
        }

        marker.on('dragend', onDragEnd);
    </script>
@endsection
