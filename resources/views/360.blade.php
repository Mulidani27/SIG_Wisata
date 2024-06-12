@extends('app')

@section('title', 'Data Wisata')

@section('content')
    <div id="panorama" style="width: 100%; height: 500px;"></div>
    <!-- Tombol Kembali menggunakan Bootstrap -->
    <button class="btn btn-outline-primary" onclick="goBack()">Kembali</button>

    <script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>
    <script>
        var panorama;
            
        panorama = pannellum.viewer('panorama', {
            "type": "equirectangular",
            "panorama": "{{ asset('uploads/' . $wisata->gambar360) }}",
            "autoLoad": true
        });

        function goBack() {
            window.history.back();
        }
    </script>

@endsection
