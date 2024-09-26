@extends('app')

@section('title', 'Data Wisata')

@section('content')
<h1 style="text-align: center"> SIG Pemetaan Wisata Kota Banjarmasin</h1>
<div class="container-fluid d-flex justify-content-center">


<div id="map"  style="height: 85vh; width: 95%;">

    <div class="search-container">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari wisata...">
    </div>

    <!-- Zoom Controls -->
    <div class="zoom-controls card card-body">
        <h5>Zoom Peta</h5>
        <input type="range" id="zoomSlider" min="0" max="22" step="0.1" value="15" class="form-range">
        <input type="number" id="zoomInput" min="0" max="22" step="0.1" value="15" class="form-control mt-2">
    </div>

    <div class="directions-panel card card-body hidden" id="directionsPanel">
        <h5>Petunjuk Arah</h5>
        <ol id="directionsList"></ol>
    </div>

    <div class="toggle-button controlsembunyi card card-body">
        <img src="{{ asset('assets/images/logo_sembunyi.png') }}" alt="Toggle Card" id="toggleButton" style="width: 20px; height: 100%; cursor: pointer;">
    </div>

<div class="controlmap card card-body hidden" id="toggleCard">
    <div class="container mt-5">
        <h4 class="mb-4">Peta Batas Wilayah</h4>

        <div class="mb-4">
    @foreach($geojsonGrouped as $kecamatan => $geojsons)
        <div class="mb-2">
            <h5>{{ $kecamatan }}</h5>
            @foreach($geojsons as $geojson)
                <div class="form-check" style="margin-left: 20px;">
                    <input type="checkbox" id="layer-{{ $geojson->id }}" class="form-check-input layer-checkbox" data-geojson="{{ asset('uploads/' . $geojson->geojson) }}">
                    <label for="layer-{{ $geojson->id }}" class="form-check-label" style="font-size: 1.2rem;">{{ $geojson->nama_wilayah }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

        <!-- Checkbox untuk menampilkan wisata dan label -->
        <div class="mb-4">
            <div class="form-check">
                <input type="checkbox" id="toggleMarkersAndLabelsCheckbox" class="form-check-input" checked>
                <label for="toggleMarkersAndLabelsCheckbox" class="form-check-label" style="font-size: 1.1rem;">Tampilkan Wisata</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="toggleLabelsCheckbox" class="form-check-input" checked>
                <label for="toggleLabelsCheckbox" class="form-check-label" style="font-size: 1.1rem;">Tampilkan Label Nama</label>
            </div>
        </div>

        <!-- Pilih Mode Peta -->
        <h4 class="mb-3">Pilih Mode Peta:</h4>
        <div class="text-center">
            <a href="{{ route('map.show', 'satelite') }}" class="btn btn-primary btn-sm mx-2">Satelite</a>
            <a href="{{ route('map.show', 'normal') }}" class="btn btn-info btn-sm mx-2">Normal</a>
        </div>
    </div>
</div>

</div>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
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
mapboxgl.accessToken = 'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
const map = new mapboxgl.Map({
    container: 'map',
    @if($map == "satelite")
        style: 'mapbox://styles/dani2705/clvudqd9601zv01ocb0jbdlif',
    @else
        style: 'mapbox://styles/mapbox/streets-v12',
    @endif
    center: [114.5914681, -3.3154437],
    zoom: 15,
});

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

    'layer-2': { lng: 114.56793712912372, lat: -3.3174116761470094 }, // Banjarmasin Barat
    'layer-3': { lng: 114.58672915941145, lat: -3.347363346824667 }, // Banjarmasin Selatan
    'layer-4': { lng: 114.59008075528719, lat: -3.318283048531195 }, // Banjarmasin Tengah
    'layer-5': { lng: 114.62408562486996, lat: -3.327262400469273 },  // Banjarmasin Timur
    'layer-6': { lng: 114.59382795069247, lat: -3.2920977438419676 } // Banjarmasin Utara
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

// Fungsi untuk memuat GeoJSON, menambahkannya sebagai layer, dan fokus ke wilayahnya
function addGeojsonLayer(url, layerId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (map.getSource(layerId)) {
                map.removeLayer(layerId);
                map.removeSource(layerId);
            }

            map.addSource(layerId, {
                type: 'geojson',
                data: data
            });

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
@foreach($wisata as $wisata)
    const marker{{$loop->index}} = new mapboxgl.Marker()
        .setLngLat(JSON.parse("{{ $wisata->lokasi }}"))
        .addTo(map);

    markers.push(marker{{$loop->index}});

    const labelDiv{{$loop->index}} = document.createElement('div');
    labelDiv{{$loop->index}}.className = 'marker-label';
    labelDiv{{$loop->index}}.textContent = '{{ $wisata->Nama_Wisata }}';
    const label{{$loop->index}} = new mapboxgl.Marker(labelDiv{{$loop->index}}, {offset: [0, -30]})
        .setLngLat(JSON.parse("{{ $wisata->lokasi }}"))
        .addTo(map);

    labels.push(label{{$loop->index}});

    marker{{$loop->index}}.getElement().addEventListener('click', function() {
        document.getElementById('offcanvasWithBothOptionsLabel').innerText = "{{ $wisata->Nama_Wisata }}";
        document.querySelector('#offcanvasWithBothOptions .offcanvas-body').innerHTML = `
            <img src="{{ asset('uploads') }}/{{$wisata->Gambar}}" class="img-fluid mb-3" alt="{{$wisata->Nama_Wisata}}">
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
                    @foreach($wisata->komentars as $komentar)
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
    const directionsRequest = `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&language=id&access_token=${mapboxgl.accessToken}`;

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

            const steps = data.routes[0].legs[0].steps;
            const directionsList = document.getElementById('directionsList');
            directionsList.innerHTML = '';
            steps.forEach(step => {
                const li = document.createElement('li');
                li.textContent = step.maneuver.instruction;
                directionsList.appendChild(li);
            });

            const directionsPanel = document.getElementById('directionsPanel');
            directionsPanel.classList.remove('hidden');
            directionsPanel.classList.add('visible');
        });
}




// Event listener untuk checkbox yang menampilkan wisata dan label
document.getElementById('toggleMarkersAndLabelsCheckbox').addEventListener('change', function() {
    markers.forEach(marker => marker.getElement().style.display = this.checked ? 'block' : 'none');
    labels.forEach(label => label.getElement().style.display = this.checked ? 'block' : 'none');
});

// Event listener untuk checkbox yang menampilkan label nama
document.getElementById('toggleLabelsCheckbox').addEventListener('change', function() {
    labels.forEach(label => label.getElement().style.display = this.checked ? 'block' : 'none');
});


document.getElementById('toggleButton').addEventListener('click', function() {
    var card = document.getElementById('toggleCard');
    if (card.classList.contains('hidden')) {
        card.classList.remove('hidden');
        card.classList.add('visible');
    } else {
        card.classList.remove('visible');
        card.classList.add('hidden');
    }
});



// map.on('load', () => {
//     // Tambahkan Geolocate control ke peta
//     map.addControl(new mapboxgl.GeolocateControl({
//         positionOptions: {
//             enableHighAccuracy: true
//         },
//         trackUserLocation: true
//     }));

//     // Tambahkan event listener untuk Geolocate control jika diperlukan
//     map.on('geolocate', (e) => {
//         console.log('Posisi saat ini:', e.coords.longitude, e.coords.latitude);
//     });
// });
</script>


@endsection
