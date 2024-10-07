@extends('app')

@section('title', 'Data Wisata')

@section('content')

    <br>
    <div class="container-fluid d-flex justify-content-center">


        <div id="map">

            <div class="search-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari wisata...">

            </div>
            <div id="filter-buttons">
                <button class="btn-filter " data-category="olahraga">Olahraga</button>
                <button class="btn-filter" data-category="religi">Religi</button>
                <button class="btn-filter" data-category="agro">Agro</button>
                <button class="btn-filter" data-category="gua">Gua</button>
                <button class="btn-filter" data-category="belanja">Belanja</button>
                <button class="btn-filter" data-category="ekologi">Ekologi</button>
                <button class="btn-filter" data-category="kuliner">Kuliner</button>
                <button class="btn-filter" data-category="all">Semua</button>
            </div>



            <!-- Zoom Controls -->
            <div class="zoom-controls card card-body">
                <h5>Zoom Peta</h5>
                <input type="range" id="zoomSlider" min="0" max="22" step="0.1" value="15"
                    class="form-range">
                <input type="number" id="zoomInput" min="0" max="22" step="0.1" value="15"
                    class="form-control">
            </div>


            <div id="directionsPanel" class="hidden">
                <ul id="directionsList"></ul>
            </div>


            <button id="toggleDirections">Sembunyikan Petunjuk</button>


            <div class="directions-panel card card-body hidden" id="directionsPanel">
                <h5>Petunjuk Arah</h5>
                <ol id="directionsList"></ol>
            </div>

            <div class="toggle-button controlsembunyi card card-body">
                <img src="{{ asset('assets/images/logo_sembunyi.png') }}" alt="Toggle Card" id="toggleButton"
                    style="width: 20px; height: 100%; cursor: pointer;">
            </div>

            <div class="controlmap card card-body hidden" id="toggleCard">
                <div class="container mt-5">
                    <h4 class="mb-4">Peta Batas Wilayah</h4>

                    <div class="mb-4">
                        @foreach ($geojsonGrouped as $kecamatan => $geojsons)
                            <div class="mb-2">
                                <h5>{{ $kecamatan }}</h5>
                                @foreach ($geojsons as $geojson)
                                    <div class="form-check" style="margin-left: 20px;">
                                        <input type="checkbox" id="layer-{{ $geojson->id }}"
                                            class="form-check-input layer-checkbox"
                                            data-geojson="{{ asset('uploads/' . $geojson->geojson) }}">
                                        <label for="layer-{{ $geojson->id }}" class="form-check-label"
                                            style="font-size: 1.2rem;">{{ $geojson->nama_wilayah }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <!-- Checkbox untuk menampilkan wisata dan label -->
                    {{-- <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" id="toggleMarkersAndLabelsCheckbox" class="form-check-input" checked>
                            <label for="toggleMarkersAndLabelsCheckbox" class="form-check-label"
                                style="font-size: 1.1rem;">Tampilkan Wisata</label>
                        </div> --}}
                    <div class="form-check">
                        <input type="checkbox" id="toggleLabelsCheckbox" class="form-check-input" checked>
                        <label for="toggleLabelsCheckbox" class="form-check-label" style="font-size: 1.1rem;">Tampilkan
                            Label Nama</label>
                    </div>
                </div>

                <!-- Pilih Mode Peta -->
                <br>
                <h4 class="mb-3">Pilih Mode Peta:</h4>
                <div class="text-center">
                    <a href="{{ route('map.show', 'satelite') }}" class="btn btn-primary btn-sm mx-2">Satelite</a>
                    <a href="{{ route('map.show', 'normal') }}" class="btn btn-info btn-sm mx-2">Normal</a>
                </div>
            </div>
        </div>

    </div>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Informasi Wisata</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Memuat informasi...</p>
        </div>
    </div>
    </div>
    <script>
        mapboxgl.accessToken =
            'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
        const map = new mapboxgl.Map({
            container: 'map',
            @if ($map == 'satelite')
                style: 'mapbox://styles/dani2705/clvudqd9601zv01ocb0jbdlif',
            @else
                style: 'mapbox://styles/mapbox/streets-v12',
            @endif
            center: [114.5914681, -3.3154437],
            zoom: 14.5,
        });


        // Batas wilayah Banjarmasin yang diizinkan
        const bounds = [
            [114.4517, -3.4127], // Koordinat Barat Daya (Southwest) Banjarmasin
            [114.7026, -3.2286] // Koordinat Timur Laut (Northeast) Banjarmasin
        ];

        // Set batas maksimum peta
        map.setMaxBounds(bounds);

        const zoomSlider = document.getElementById('zoomSlider');
        const zoomInput = document.getElementById('zoomInput');

        // Update zoom when the slider changes
        zoomSlider.addEventListener('input', function() {
            map.setZoom(parseFloat(zoomSlider.value));
            zoomInput.value = zoomSlider.value;
        });

        // Update zoom when the input number changes
        zoomInput.addEventListener('input', function() {
            map.setZoom(parseFloat(zoomInput.value));
            zoomSlider.value = zoomInput.value;
        });

        // Update slider and input when the map's zoom level changes
        map.on('zoom', function() {
            const zoomLevel = map.getZoom().toFixed(1); // Get zoom level and fix to 1 decimal
            zoomSlider.value = zoomLevel;
            zoomInput.value = zoomLevel;
        });

        const fullscreenControl = new mapboxgl.FullscreenControl();
        map.addControl(fullscreenControl, 'top-left');

        // Titik tengah untuk setiap kecamatan
        const districtCenters = {

            'layer-2': {
                lng: 114.56793712912372,
                lat: -3.3174116761470094
            }, // Banjarmasin Barat
            'layer-3': {
                lng: 114.58672915941145,
                lat: -3.347363346824667
            }, // Banjarmasin Selatan
            'layer-4': {
                lng: 114.59008075528719,
                lat: -3.318283048531195
            }, // Banjarmasin Tengah
            'layer-5': {
                lng: 114.62408562486996,
                lat: -3.327262400469273
            }, // Banjarmasin Timur
            'layer-13': {
                lng: 114.59382795069247,
                lat: -3.2920977438419676
            }, // Banjarmasin Utara
            'layer-14': {
                lng: 114.5914681, 
                lat: -3.3154437
            } // Banjarmasin Kota
        };

        // Fungsi untuk mendapatkan warna acak
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function addGeojsonLayer(url, layerId) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Menghapus layer dan source jika sudah ada
                if (map.getSource(layerId)) {
                    map.removeLayer(layerId);
                    map.removeSource(layerId);
                }

                // Menambahkan GeoJSON sebagai source baru
                map.addSource(layerId, {
                    type: 'geojson',
                    data: data
                });

                // Menambahkan layer batas wilayah (fill layer)
                map.addLayer({
                    'id': layerId,
                    'type': 'fill',
                    'source': layerId,
                    'layout': {},
                    'paint': {
                        'fill-color': getRandomColor(), // Warna acak untuk setiap kecamatan
                        'fill-opacity': 0.4
                    }
                });

                // Event listener untuk menampilkan nama kecamatan saat diklik
                map.on('click', layerId, function(e) {
                    const feature = e.features[0];
                    console.log(feature); // Cek properti dari GeoJSON
                    const kecamatan = feature.properties.kecamatan; // Ambil nama kecamatan dari GeoJSON properties

                    // Hapus layer teks jika sudah ada
                    if (map.getLayer(`${layerId}-label`)) {
                        map.removeLayer(`${layerId}-label`);
                    }

                    // Tambahkan layer teks di atas layer batas wilayah
                    map.addLayer({
                        'id': `${layerId}-label`,
                        'type': 'symbol',
                        'source': layerId,
                        'layout': {
                            'text-field': kecamatan, // Tampilkan nama kecamatan
                            'text-size': 25, // Ukuran teks
                            'text-transform': 'uppercase', // Format teks
                            'text-offset': [0, 1.5], // Jarak teks dari titik pusat
                            'text-anchor': 'top'
                        },
                        'paint': {
                            'text-color': '#000000' // Warna teks hitam
                        }
                    });
                });

                // Mendapatkan titik tengah dari objek
                const center = districtCenters[layerId];

                if (center) {
                    console.log(`Fokus ke ${layerId} dengan koordinat ${center.lat}, ${center.lng}`);
                    // Fokus peta ke titik tengah yang ditentukan
                    map.flyTo({
                        center: [center.lng, center.lat],
                        zoom: 14, // Ubah nilai zoom sesuai kebutuhan
                        essential: true // Hanya lakukan animasi jika perlu
                    });
                } else {
                    console.error(`Titik tengah tidak ditemukan untuk layer ${layerId}`);
                }
            })
            .catch(error => console.error('Error loading GeoJSON:', error));
    }


        // Fungsi untuk menghapus layer GeoJSON
        function removeGeojsonLayer(layerId) {
            if (map.getSource(layerId)) {
                map.removeLayer(layerId);
                map.removeSource(layerId);
            }
        }

        // Event listener untuk checkbox dinamis
        document.querySelectorAll('.layer-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                var layerId = 'layer-' + this.id.split('-')[1];
                if (this.checked) {
                    addGeojsonLayer(this.dataset.geojson, layerId);
                } else {
                    removeGeojsonLayer(layerId);
                }
            });
        });

        const markers = [];
        const labels = [];
        const wisataCategories = [];
        const selectedCategories = [];
        console.log(wisataCategories);

        // Loop untuk menambahkan marker dan label ke peta
        @foreach ($wisata as $wisata)
// Function untuk membuat elemen marker kustom berdasarkan jenis wisata
function createCustomMarker(jenisWisata) {
    const el = document.createElement('div');
    el.className = 'custom-marker';
    
    el.style.paddingBottom = '55px'; // Atur margin bawah untuk mengangkat marker lebih tinggi

    const icon = document.createElement('img');
    icon.style.width = '60px';  // Ukuran lebar
    icon.style.height = '60px'; // Ukuran tinggi
    icon.style.objectFit = 'contain'; // Pastikan rasio aspek tetap
   

    // Tentukan gaya marker berdasarkan jenis wisata
    switch (jenisWisata) {
        case 'olahraga':
            icon.src = "{{ asset('assets/images/olahraga.png') }}";
            break;
        case 'religi':
            icon.src = "{{ asset('assets/images/religi.png') }}";
            break;
        case 'agro':
            icon.src = "{{ asset('assets/images/agro.png') }}";
            break;
        case 'gua':
            icon.src = "{{ asset('assets/images/gua.png') }}";
            break;
        case 'belanja':
            icon.src = "{{ asset('assets/images/belanja.png') }}";
            break;
        case 'ekologi':
            icon.src = "{{ asset('assets/images/ekologi.png') }}";
            break;
        case 'kuliner':
            icon.src = "{{ asset('assets/images/kuliner.png') }}";
            break;
        default:
            icon.src = "{{ asset('assets/images/kuliner.png') }}";
            }

            el.appendChild(icon);

    return el;
}

// Iterasi marker berdasarkan data wisata
const el{{ $loop->index }} = createCustomMarker('{{ $wisata->Jenis_Wisata }}');

const marker{{ $loop->index }} = new mapboxgl.Marker(el{{ $loop->index }})
    .setLngLat(JSON.parse("{{ $wisata->lokasi }}"))
    .addTo(map); // Menambahkan marker ke peta dengan elemen kustom

markers.push({
    marker: marker{{ $loop->index }},
    category: '{{ $wisata->Jenis_Wisata }}' // Simpan kategori marker
});


            // Membuat label untuk wisata
            const labelDiv{{ $loop->index }} = document.createElement('div');
            labelDiv{{ $loop->index }}.className = 'marker-label';
            labelDiv{{ $loop->index }}.textContent = '{{ $wisata->Nama_Wisata }}';

            const label{{ $loop->index }} = new mapboxgl.Marker(labelDiv{{ $loop->index }}, {
                    offset: [0, -30]
                })
                .setLngLat(JSON.parse("{{ $wisata->lokasi }}"))
                .addTo(map); // Menambahkan label ke peta secara default

            labels.push({
                label: label{{ $loop->index }},
                category: '{{ $wisata->Jenis_Wisata }}' // Simpan kategori label
            });

            // Event listener untuk menampilkan detail saat marker diklik
            marker{{ $loop->index }}.getElement().addEventListener('click', function() {
                document.getElementById('offcanvasWithBothOptionsLabel').innerText = "{{ $wisata->Nama_Wisata }}";
                document.querySelector('#offcanvasWithBothOptions .offcanvas-body').innerHTML = `
            <img src="{{ asset('uploads') }}/{{ $wisata->Gambar }}" class="img-fluid mb-3" alt="{{ $wisata->Nama_Wisata }}">
            <div class="details">
                <h2 class="fw-bold">{{ $wisata->Nama_Wisata }}</h2>
                <h5 class="text-muted">Jenis Wisata: {{ $wisata->Jenis_Wisata }}</h5>
                <h6 class="text-muted">Alamat: {{ $wisata->Alamat }}</h6>
                <p id="detail-text" class="text-justify">
                    {{ Str::limit($wisata->Detail, 150) }}
                    <span id="dots">...</span>
                    <span id="more" style="display: none;">{{ $wisata->Detail }}</span>
                </p>
                <button onclick="toggleDetail()" id="toggleDetailButton" class="btn btn-link p-0">Tampilkan lebih banyak</button>
                <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('map.view', $wisata->id) }}" role="button">Lihat Gambar 360</a>
                    <button class="btn btn-secondary mt-2" onclick="promptForStartingPoint('{{ $wisata->lokasi }}')">Dapatkan Rute</button>
                </div>
            </div>

            <div class="komentar-rating mt-5">
                <h4 class="fw-bold">Komentar dan Rating</h4>
                <form action="{{ route('komentars.store', $wisata->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Kirim Komentar</button>
                </form>

                <div class="daftar-komentar mt-4">
                    <h5 class="fw-bold mb-3">Komentar Pengguna</h5>
                    @foreach ($wisata->komentars as $komentar)
                        <div class="komentar-item mb-3 p-3 border rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $komentar->nama }}</strong>
                                <span class="badge bg-info text-dark">{{ $komentar->rating }} / 5</span>
                            </div>
                            <p class="mb-1">{{ $komentar->komentar }}</p>
                            <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        `;
                var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                offcanvas.show();
            });
        @endforeach

         // Fungsi untuk menampilkan atau menyembunyikan marker berdasarkan kategori
         function filterMarkers(category) {
            markers.forEach((item, index) => {
                if (item.category == category || category === "all") {
                    item.marker.addTo(map); // Tampilkan marker
                    labels[index].label.addTo(map); // Tampilkan label
                } else {
                    item.marker.remove(); // Sembunyikan marker
                    labels[index].label.remove(); // Sembunyikan label
                }
            });
        }


        // Tambahkan event listener ke tombol-tombol filter
        document.querySelectorAll('.btn-filter').forEach(button => {
            button.addEventListener('click', (e) => {
                const category = e.target.getAttribute('data-category');
                filterMarkers(category);


            });
        });
        


        document.querySelectorAll('.btn-filter').forEach(button => {
            button.addEventListener('click', function() {
                // Menghapus kelas 'active' dari semua tombol
                document.querySelectorAll('.btn-filter').forEach(btn => btn.classList.remove('active'));

                // Menambahkan kelas 'active' ke tombol yang diklik
                this.classList.add('active');
            });
        });




        // Fungsi ini meminta pengguna untuk menentukan titik awal perjalanan, baik menggunakan lokasi saat ini atau memasukkan koordinat secara manual.
        function promptForStartingPoint(destination) {
            const useGeolocation = confirm("Apakah Anda ingin menggunakan lokasi Anda saat ini sebagai titik awal?");

            if (useGeolocation) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const start = [position.coords.longitude, position.coords.latitude];
                        const end = JSON.parse(destination);
                        getRoute(start, end);
                    }, function(error) {
                        alert("Tidak dapat mengakses lokasi Anda. Silakan masukkan koordinat secara manual.");
                        promptForCoordinates(destination);
                    });
                } else {
                    alert("Browser Anda tidak mendukung geolokasi.");
                    promptForCoordinates(destination);
                }
            } else {
                promptForCoordinates(destination);
            }
        }

        // Fungsi ini meminta pengguna untuk memasukkan koordinat latitude dan longitude sebagai titik awal perjalanan, kemudian memanggil fungsi getRoute jika koordinat valid.
        function promptForCoordinates(destination) {
            const startLat = prompt("Masukkan latitude titik awal:");
            const startLng = prompt("Masukkan longitude titik awal:");

            if (startLat && startLng) {
                const start = [parseFloat(startLng), parseFloat(startLat)];
                const end = JSON.parse(destination);
                getRoute(start, end);
            } else {
                alert("Koordinat tidak valid.");
            }
        }

        function getRoute(start, end) {
            const directionsRequest =
                `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&language=id&access_token=${mapboxgl.accessToken}`;

            fetch(directionsRequest)
                .then(response => response.json())
                .then(data => {
                    const route = data.routes[0].geometry.coordinates;
                    const geojson = {
                        type: 'Feature',
                        properties: {},
                        geometry: {
                            type: 'LineString',
                            coordinates: route
                        }
                    };

                    if (map.getSource('route')) {
                        map.getSource('route').setData(geojson);
                    } else {
                        map.addLayer({
                            id: 'route',
                            type: 'line',
                            source: {
                                type: 'geojson',
                                data: geojson
                            },
                            layout: {
                                'line-join': 'round',
                                'line-cap': 'round'
                            },
                            paint: {
                                'line-color': '#3887be',
                                'line-width': 5,
                                'line-opacity': 0.75
                            }
                        });
                    }

                    // Tampilkan petunjuk arah
                    const steps = data.routes[0].legs[0].steps;
                    const directionsList = document.getElementById('directionsList');
                    directionsList.innerHTML = ''; // Kosongkan daftar sebelumnya
                    steps.forEach(step => {
                        const li = document.createElement('li');
                        li.textContent = step.maneuver.instruction;
                        directionsList.appendChild(li);
                    });

                    // Tampilkan panel petunjuk dan tombol
                    const directionsPanel = document.getElementById('directionsPanel');
                    directionsPanel.classList.remove('hidden');
                    directionsPanel.classList.add('visible');

                    // Tampilkan tombol hanya jika ada rute
                    const toggleButton = document.getElementById('toggleDirections');
                    toggleButton.style.display = 'block'; // Menampilkan tombol setelah rute dibuat
                });
        }



        // Fungsi ini untuk mengubah tampilan detail teks. 
        // Ketika dipanggil, ia akan menyembunyikan atau menampilkan teks tambahan, 
        // serta mengubah teks pada tombol untuk menunjukkan apakah pengguna dapat melihat lebih banyak atau lebih sedikit.
        function toggleDetail() {
            var moreText = document.getElementById("more");
            var dots = document.getElementById("dots");
            var button = document.getElementById("toggleDetailButton");

            if (moreText.style.display === "none") {
                dots.style.display = "none";
                moreText.style.display = "inline";
                button.innerText = "Tampilkan lebih sedikit";
            } else {
                dots.style.display = "inline";
                moreText.style.display = "none";
                button.innerText = "Tampilkan lebih banyak";
            }
        }


        // Fungsi ini untuk mengatur tampilan marker dan label pada peta. 
        // Jika parameter 'checked' bernilai true, marker ditampilkan di peta dan label diatur untuk terlihat. 
        // Jika false, marker dihapus dari peta dan label disembunyikan.
        // function toggleMarkersAndLabels(checked) {
        //     if (checked) {
        //         markers.forEach(marker => marker.addTo(map));
        //         labels.forEach(label => label.getElement().style.display = 'block');
        //     } else {
        //         markers.forEach(marker => marker.remove());
        //         labels.forEach(label => label.getElement().style.display = 'none');
        //     }
        // }

        // Menambahkan event listener pada checkbox untuk mengatur tampilan marker dan label saat status checkbox berubah.
        // document.getElementById('toggleMarkersAndLabelsCheckbox').addEventListener('change', function() {
        //     toggleMarkersAndLabels(this.checked);
        // });

        // // Event listener untuk checkbox yang menampilkan wisata dan label
        // document.getElementById('toggleMarkersAndLabelsCheckbox').addEventListener('change', function() {
        //     markers.forEach(marker => marker.getElement().style.display = this.checked ? 'block' : 'none');
        //     labels.forEach(label => label.getElement().style.display = this.checked ? 'block' : 'none');
        // });

        // Menambahkan event listener pada tombol untuk menampilkan atau menyembunyikan kartu (card) saat tombol diklik.
        document.getElementById('toggleButton').addEventListener('click', function() {
            var card = document.getElementById('toggleCard');
            if (card.classList.contains('hidden')) {
                card.classList.remove('hidden'); // Menghapus kelas 'hidden' jika kartu tersembunyi.
                card.classList.add('visible'); // Menambahkan kelas 'visible' untuk menampilkan kartu.
            } else {
                card.classList.remove('visible'); // Menghapus kelas 'visible' jika kartu terlihat.
                card.classList.add('hidden'); // Menambahkan kelas 'hidden' untuk menyembunyikan kartu.
            }
        });

        // Menunggu sampai seluruh konten halaman dimuat sebelum menjalankan fungsi berikut.
        document.addEventListener('DOMContentLoaded', function() {
            const toggleLabelsCheckbox = document.getElementById('toggleLabelsCheckbox');
            const labels = document.querySelectorAll('.marker-label');

            // Mengatur tampilan label berdasarkan status checkbox saat halaman dimuat.
            const visibility = toggleLabelsCheckbox.checked ? 'block' : 'none';
            labels.forEach(label => {
                label.style.display = visibility;
            });

            // Menambahkan event listener pada checkbox untuk mengatur tampilan label saat status checkbox berubah.
            toggleLabelsCheckbox.addEventListener('change', function() {
                const visibility = this.checked ? 'block' : 'none';
                labels.forEach(label => {
                    label.style.display =
                        visibility; // Mengubah tampilan label berdasarkan status checkbox.
                });
            });
        });


        // Ambil referensi elemen input
        const searchInput = document.getElementById('searchInput');

        // Tambahkan event listener untuk mendeteksi perubahan pada input pencarian
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase();

            // Loop melalui semua marker dan label untuk menyembunyikan atau menampilkan berdasarkan pencarian
            markers.forEach((marker, index) => {
                const wisataName = labels[index].getElement().textContent.toLowerCase();

                if (wisataName.includes(query)) {
                    marker.getElement().style.display = 'block';
                    labels[index].getElement().style.display = 'block';
                } else {
                    marker.getElement().style.display = 'none';
                    labels[index].getElement().style.display = 'none';
                }
            });
        });


        // Menambahkan event listener pada tombol untuk menampilkan atau menyembunyikan elemen dengan ID 'toggleCard' saat tombol diklik.
        document.getElementById('toggleButton').addEventListener('click', function() {
            const toggleCard = document.getElementById('toggleCard'); // Mendapatkan elemen yang ingin di-toggle.

            // Memeriksa apakah 'toggleCard' memiliki kelas 'hidden'.
            if (toggleCard.classList.contains('hidden')) {
                toggleCard.classList.remove('hidden'); // Menghapus kelas 'hidden' untuk menampilkan kartu.
            } else {
                toggleCard.classList.add('hidden'); // Menambahkan kelas 'hidden' untuk menyembunyikan kartu.
            }
        });



        // Event listener untuk checkbox yang menampilkan label nama
        document.getElementById('toggleLabelsCheckbox').addEventListener('change', function() {
            labels.forEach(label => label.getElement().style.display = this.checked ? 'block' : 'none');
        });

        // Menambahkan event listener pada tombol dengan ID 'toggleButton' untuk mengatur visibilitas elemen dengan ID 'toggleCard' saat tombol diklik.
        document.getElementById('toggleButton').addEventListener('click', function() {
            var card = document.getElementById('toggleCard'); // Mendapatkan elemen yang ingin di-toggle.

            // Memeriksa apakah 'card' memiliki kelas 'hidden'.
            if (card.classList.contains('hidden')) {
                card.classList.remove('hidden'); // Menghapus kelas 'hidden' untuk menampilkan kartu.
                card.classList.add(
                    'visible'); // Menambahkan kelas 'visible' untuk menandai bahwa kartu sekarang terlihat.
            } else {
                card.classList.remove('visible'); // Menghapus kelas 'visible' jika kartu sudah terlihat.
                card.classList.add('hidden'); // Menambahkan kelas 'hidden' untuk menyembunyikan kartu.
            }
        });

        map.on('load', () => {
            // Tambahkan Geolocate control ke peta
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            }));

            // Tambahkan event listener untuk Geolocate control jika diperlukan
            map.on('geolocate', (e) => {
                console.log('Posisi saat ini:', e.coords.longitude, e.coords.latitude);
            });
        });

        // Mendapatkan elemen tombol untuk toggle dan panel petunjuk.
        const toggleButton = document.getElementById('toggleDirections');
        const directionsPanel = document.getElementById('directionsPanel');

        // Menambahkan event listener untuk tombol yang akan mengatur visibilitas panel petunjuk saat tombol diklik.
        toggleButton.addEventListener('click', function() {
            if (directionsPanel.classList.contains('hidden-panel')) {
                // Tampilkan panel petunjuk jika tersembunyi
                directionsPanel.classList.remove(
                    'hidden-panel'); // Menghapus kelas 'hidden-panel' untuk menampilkan panel.
                toggleButton.textContent =
                    'Sembunyikan Petunjuk'; // Mengubah teks tombol menjadi 'Sembunyikan Petunjuk'.
            } else {
                // Sembunyikan panel petunjuk
                directionsPanel.classList.add(
                    'hidden-panel'); // Menambahkan kelas 'hidden-panel' untuk menyembunyikan panel.
                toggleButton.textContent =
                    'Tampilkan Petunjuk'; // Mengubah teks tombol menjadi 'Tampilkan Petunjuk'.
            }
        });

    </script>


@endsection
