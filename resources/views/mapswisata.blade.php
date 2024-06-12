@extends('app')

@section('title', 'Data Wisata')

@section('content')
<div id="map">
    <div class="toggle-button controlsembunyi card card-body">
        <img src="{{ asset('assets/images/logo_sembunyi.png')}}" alt="Toggle Card" id="toggleButton" style="width: 20px; height: 100%;">
    </div>
    <div class="controlmap card card-body hidden" id="toggleCard">
        <br>
        <br>
        <h4>Pilih Kecamatan:</h4>
        <label><input type="checkbox" id="banjarmasinUtaraCheckbox" > Banjarmasin Utara</label><br><br>
        <label><input type="checkbox" id="banjarmasinTengahCheckbox" > Banjarmasin Tengah</label><br><br>
        <label><input type="checkbox" id="banjarmasinBaratCheckbox" > Banjarmasin Barat</label><br><br>
        <label><input type="checkbox" id="banjarmasinTimurCheckbox" > Banjarmasin Timur</label><br><br>
        <label><input type="checkbox" id="banjarmasinSelatanCheckbox" > Banjarmasin Selatan</label><br><br>
        <label><input type="checkbox" checked id="toggleMarkersAndLabelsCheckbox" >Tampilkan Wisata</label><br> <br>

        <h4>Pilih Mode Peta:</h4>

        <div style="text-align: center;">
            <a href="{{route('map.show','satelite')}}" class="btn btn-sm btn-primary" style="color: aliceblue;">Satelite</a>
            <br><br>
            <a href="{{route('map.show','normal')}}" class="btn btn-sm btn-info" style="color: aliceblue;">Normal</a>
        </div>
    </div>
</div>

<!-- Offcanvas -->
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
        center: [114.591212, -3.318965],
        zoom: 15,
    });

    const fullscreenControl = new mapboxgl.FullscreenControl();
    map.addControl(fullscreenControl, 'top-left');

    const kecamatanLayers = {
        'banjarmasinUtara': 'kabupaten-banjarmasin-utara-layer',
        'banjarmasinTengah': 'kabupaten-banjarmasin-tengah-layer',
        'banjarmasinBarat': 'kabupaten-banjarmasin-barat-layer',
        'banjarmasinTimur': 'kabupaten-banjarmasin-timur-layer',
        'banjarmasinSelatan': 'kabupaten-banjarmasin-selatan-layer'
    };

    map.on('load', () => {
        for (const [kecamatan, layerId] of Object.entries(kecamatanLayers)) {
            map.addSource(kecamatan, {
                type: 'geojson',
                data: '/assets/js/map.geojson',
            });

            map.addLayer({
                'id': layerId,
                'type': 'fill',
                'source': kecamatan,
                'paint': {
                    'fill-color': getFillColor(kecamatan),
                    'fill-opacity': 0.3,
                },
                'layout': {
                    'visibility': 'none'
                },
                'filter': ['==', 'kecamatan', `Banjarmasin ${kecamatan.replace('banjarmasin', '').trim()}`]
            });
        }
    });

    function getFillColor(kecamatan) {
        switch (kecamatan) {
            case 'banjarmasinUtara':
                return '#ff0000';
            case 'banjarmasinTengah':
                return '#00ff00';
            case 'banjarmasinBarat':
                return '#0000ff';
            case 'banjarmasinTimur':
                return '#ffff00';
            case 'banjarmasinSelatan':
                return '#ff00ff';
            default:
                return '#ffffff';
        }
    }

    for (const [kecamatan, layerId] of Object.entries(kecamatanLayers)) {
        const checkbox = document.getElementById(`${kecamatan}Checkbox`);
        checkbox.addEventListener('change', function() {
            const visibility = this.checked ? 'visible' : 'none';
            map.setLayoutProperty(layerId, 'visibility', visibility);
        });
    }

    const markers = [];
    const labels = [];

    @foreach($wisata as $wisata)
        const marker{{$loop->index}} = new mapboxgl.Marker()
            .setLngLat(JSON.parse("{{ $wisata->lokasi}}"))
            .addTo(map);

        markers.push(marker{{$loop->index}});

        const labelDiv{{$loop->index}} = document.createElement('div');
        labelDiv{{$loop->index}}.className = 'marker-label';
        labelDiv{{$loop->index}}.textContent = '{{$wisata->Nama_Wisata}}';
        const label{{$loop->index}} = new mapboxgl.Marker(labelDiv{{$loop->index}}, {offset: [0, -30]})
            .setLngLat(JSON.parse("{{ $wisata->lokasi}}"))
            .addTo(map);

        labels.push(label{{$loop->index}});

        marker{{$loop->index}}.getElement().addEventListener('click', function() {
            document.getElementById('offcanvasWithBothOptionsLabel').innerText = "{{$wisata->Nama_Wisata}}";
            document.querySelector('#offcanvasWithBothOptions .offcanvas-body').innerHTML = `
                <img src="{{asset('uploads')}}/{{$wisata->Gambar}}" class="img-fluid mb-3" alt="{{$wisata->Nama_Wisata}}">
                <h3>{{$wisata->Nama_Wisata}}</h3>
                <h6>Wisata {{$wisata->Jenis_Wisata}}</h6>
                <p>{{$wisata->Detail}}</p>
                <a class="btn btn-primary" href="{{route("map.view",$wisata->id)}}" role="button">Gambar 360</a>
            `;
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
            offcanvas.show();
        });
    @endforeach

    map.on('zoom', function() {
        var offcanvasElement = document.getElementById('offcanvasWithBothOptions');
        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (!offcanvas) {
            offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        }
        offcanvas.show();
    });

    function toggleMarkersAndLabels(checked) {
        if (checked) {
            markers.forEach(marker => marker.addTo(map));
            labels.forEach(label => label.addTo(map));
        } else {
            markers.forEach(marker => marker.remove());
            labels.forEach(label => label.remove());
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
</script>
@endsection
