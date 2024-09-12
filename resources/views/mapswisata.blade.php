@extends('app')

@section('title', 'Data Wisata')

@section('content')

<div id="map">

    <div class="search-container">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari wisata...">
    </div>

    <div class="directions-panel card card-body hidden" id="directionsPanel">
        <h5>Petunjuk Arah</h5>
        <ol id="directionsList"></ol>
    </div>

    <div class="toggle-button controlsembunyi card card-body">
        <img src="{{ asset('assets/images/logo_sembunyi.png') }}" alt="Toggle Card" id="toggleButton" style="width: 20px; height: 100%;">
    </div>
    
    <div class="controlmap card card-body hidden" id="toggleCard">
        
        <div class="container mt-5">

        <div class="container mt-4">
    <h4 class="mb-4">Peta Batas Wilayah</h4>

    <!-- Checkbox untuk menampilkan batas wilayah -->
    <div class="mb-4">
        @foreach($geojsons as $geojson)
            <div class="form-check">
                <input type="checkbox" id="layer-{{ $geojson->id }}" class="form-check-input layer-checkbox" data-geojson="{{ asset('uploads/' . $geojson->geojson) }}">
                <label for="layer-{{ $geojson->id }}" class="form-check-label" style="font-size: 1.2rem;">{{ $geojson->nama_wilayah }}</label>
            </div>
        @endforeach
    </div>

    <!-- Checkbox untuk menampilkan wisata dan label -->
    <div class="mb-4">
        <div class="form-check">
            <input type="checkbox" id="toggleMarkersAndLabelsCheckbox" class="form-check-input" checked>
            <label for="toggleMarkersAndLabelsCheckbox" class="form-check-label" style="font-size: 1.1rem; ">Tampilkan Wisata</label>
        </div>
        <div class="form-check">
            <input type="checkbox" id="toggleLabelsCheckbox" class="form-check-input">
            <label for="toggleLabelsCheckbox" class="form-check-label" style="font-size: 1.1rem; ">Tampilkan Label Nama</label>
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

    const fullscreenControl = new mapboxgl.FullscreenControl();
    map.addControl(fullscreenControl, 'top-left');

  
        // Fungsi untuk mendapatkan warna acak
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Fungsi untuk memuat GeoJSON dan menambahkannya sebagai layer
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
                <img src="{{asset('uploads')}}/{{$wisata->Gambar}}" class="img-fluid mb-3" alt="{{$wisata->Nama_Wisata}}">
                <div class="details">
                    <h2>{{ $wisata->Nama_Wisata }}</h2>
                    <h5>Jenis Wisata: {{ $wisata->Jenis_Wisata }}</h5>
                    <h6>Alamat: {{ $wisata->Alamat }}</h6>
                    <p style="text-align: justify;">{{ $wisata->Detail }}</p>
                    <a class="btn btn-primary" href="{{ route('map.view', $wisata->id) }}" role="button">Lihat Gambar 360</a>
                    <button class="btn btn-secondary mt-2" onclick="getRoute([114.5914681, -3.3154437], JSON.parse('{{ $wisata->lokasi }}'))">Dapatkan Rute</button>
                </div>`;
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
            offcanvas.show();
        });
    @endforeach

    function toggleMarkersAndLabels(checked) {
        if (checked) {
            markers.forEach(marker => marker.addTo(map));
            labels.forEach(label => label.getElement().style.display = 'block');
        } else {
            markers.forEach(marker => marker.remove());
            labels.forEach(label => label.getElement().style.display = 'none');
        }
    }

    document.getElementById('toggleMarkersAndLabelsCheckbox').addEventListener('change', function() {
        toggleMarkersAndLabels(this.checked);
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

    document.addEventListener('DOMContentLoaded', function() {
        const toggleLabelsCheckbox = document.getElementById('toggleLabelsCheckbox');
        const labels = document.querySelectorAll('.marker-label');

        const visibility = toggleLabelsCheckbox.checked ? 'block' : 'none';
        labels.forEach(label => {
            label.style.display = visibility;
        });

        toggleLabelsCheckbox.addEventListener('change', function() {
            const visibility = this.checked ? 'block' : 'none';
            labels.forEach(label => {
                label.style.display = visibility;
            });
        });
    });

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

</script>

@endsection
