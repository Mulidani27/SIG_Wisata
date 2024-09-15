@extends('app')

@section('title', 'Data Wisata')

@section('content')

    <div class="container my-4">
        <!-- Kontainer untuk panorama -->
        <div id="panorama" class="rounded shadow" style="width: 100%; height: 700px;"></div>
        
        <!-- Tombol Kembali dengan posisi lebih baik -->
        <div class="text-center mt-3">
            <button class="btn btn-outline-primary" onclick="goBack()">Kembali</button>
        </div>
    </div>

    <!-- Script untuk menampilkan panorama -->
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
