<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Animate a point along a route</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css">
<style>
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    body { margin: 0; padding: 0; }
    #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    .marker-name {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .overlay {
        position: absolute;
        top: 50px;
        right: 50px;
    }
    .marker-label {
        font-size: 12px;
        color: black;
        text-align: center;
        background-color: white;
        border-radius: 4px;
        padding: 2px 6px;
        top: 45px;
    }
</style>
</head>
<body>

<div id="map"></div>

<div class="overlay card card-body ">

    <br>
    
    <h4>Pilih Kecamatan:</h4>
    <label><input type="checkbox" id="banjarmasinUtaraCheckbox" > Banjarmasin Utara</label><br>
    <label><input type="checkbox" id="banjarmasinTengahCheckbox" > Banjarmasin Tengah</label><br>
    <label><input type="checkbox" id="banjarmasinBaratCheckbox" > Banjarmasin Barat</label><br>
    <label><input type="checkbox" id="banjarmasinTimurCheckbox" > Banjarmasin Timur</label><br>
    <label><input type="checkbox" id="banjarmasinSelatanCheckbox" > Banjarmasin Selatan</label><br>
    <br>
    <label><input type="checkbox" checked id="toggleMarkersAndLabelsCheckbox" > Wisata</label><br> 
    
    <h4>Pilih Mode Peta:</h4>
    <a href="{{route("map.show","satelite")}}" class="btn btn-sm btn-primary" style="color: aliceblue;">Satelite</a>
    <a href="{{route("map.show","normal")}}" class="btn btn-sm btn-info" style="color: aliceblue;">Normal</a>
</div>

<script>
mapboxgl.accessToken = 'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
const map = new mapboxgl.Map({
    container: 'map',
    @if($map == "satelite")
         style: 'mapbox://styles/dani2705/clvudqd9601zv01ocb0jbdlif',
    @else
        style : 'mapbox://styles/mapbox/streets-v12',
    @endif
    center: [114.591212, -3.318965],
    zoom: 15,
});

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
            data: '/assets/js/map.geojson', // Ubah sintaks ini
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




// Simpan marker dan label ke dalam variabel
const markers = [];
const labels = [];

@foreach($wisata as $wisata)
    // Buat marker
    const marker{{$loop->index}} = new mapboxgl.Marker()
        .setLngLat(JSON.parse("{{ $wisata->lokasi}}")) 
        .setPopup(new mapboxgl.Popup().setHTML(`
            <div class="card">
                <img src="{{asset('assets')}}/images/{{$wisata->Gambar}}" class="card-img-top" alt="{{$wisata->Nama_Wisata}}">
                <div class="card-body">
                    <h3 class="card-title">{{$wisata->Nama_Wisata}}</h3>
                    <h6 class="card-title">Wisata {{$wisata->Jenis_Wisata}}</h5>
                    <p class="card-text">{{$wisata->Detail}}</p>
                </div>
                <br>
                <a class="btn btn-primary" href="{{route("map.view",$wisata->id)}}" role="button">Gambar 360</a>
            </div>
        `)) 
        .addTo(map);

    markers.push(marker{{$loop->index}});

    // Buat label
    const labelDiv{{$loop->index}} = document.createElement('div');
    labelDiv{{$loop->index}}.className = 'marker-label';
    labelDiv{{$loop->index}}.textContent = '{{$wisata->Nama_Wisata}}';
    const label{{$loop->index}} = new mapboxgl.Marker(labelDiv{{$loop->index}}, {offset: [0, -30]})
        .setLngLat(JSON.parse("{{ $wisata->lokasi}}"))  
        .addTo(map);

    labels.push(label{{$loop->index}});
@endforeach


// Fungsi untuk mengatur visibilitas marker dan label
function toggleMarkersAndLabels(checked) {
    if (checked) {
        markers.forEach(marker => marker.addTo(map));
        labels.forEach(label => label.addTo(map));
    } else {
        markers.forEach(marker => marker.remove());
        labels.forEach(label => label.remove());
    }
}

// Callback saat checkbox diubah
document.getElementById('toggleMarkersAndLabelsCheckbox').addEventListener('change', function() {
    toggleMarkersAndLabels(this.checked);
});



</script>
<button></button>
</body>
</html> 