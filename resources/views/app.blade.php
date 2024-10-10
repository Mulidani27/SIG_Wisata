<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <title>Animate a point along a route</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">

    <!-- Font Awesome CSS (versi terbaru) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS (versi terbaru) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

    <!-- Turf.js -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Pannellum CSS -->
    <link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- jQuery -->


    <style>
        #map {
            position: relative;
            height: 85vh;
            width: 95%;

        }

        .star-rating {
            direction: rtl;
            display: inline-block;
        }

        .star {
            font-size: 30px;
            color: lightgray;
            cursor: pointer;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked~.star {
            color: gold;
        }

        input[type="radio"]:hover~.star {
            color: gold;
        }


        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .hidden {
            display: none;
        }

        .visible {
            display: block;
        }

        .navbar {
            background-color: #0d6efd;
            /* Warna biru Bootstrap untuk latar belakang */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Tambahkan bayangan lembut */
        }

        .mapboxgl-ctrl-geolocate {
            background-color: #007cbf;
            /* Ubah warna latar belakang */
            border-radius: 50%;
            /* Membuat tombol menjadi bulat */
            width: 40px;
            /* Ukuran tombol */
            height: 40px;
            /* Ukuran tombol */
        }

        .mapboxgl-ctrl-geolocate .mapboxgl-ctrl-icon {
            background-image: url('path/to/your/icon.png');
            /* Ganti dengan path ikon Anda jika diperlukan */
        }

        .weather-section {
            position: absolute;
            /* Menggunakan posisi tetap agar tetap di atas saat scrolling */
            top: 170px;
            /* Jarak dari atas */
            left: 50px;
            /* Jarak dari kanan */
            z-index: 100;
            /* Z-index tinggi untuk menempatkannya di atas elemen lain */
            width: 300px;
            /* Atur lebar sesuai kebutuhan */
        }

        .weather-info {
            position: absolute;
            /* Agar elemen ini bisa diposisikan di atas gambar */
            top: 10px;
            /* Jarak dari atas */
            left: 10px;
            /* Jarak dari kiri */
            background-color: rgba(255, 255, 255, 0.8);
            /* Latar belakang transparan */
            padding: 5px;
            /* Padding di dalam elemen */
            border-radius: 5px;
            /* Sudut membulat */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Bayangan */
            font-size: 15px;
            /* Ukuran font kecil */
            z-index: 100 !important;
            /* Pastikan di atas elemen lainnya */
            display: none;
            /* Sembunyikan secara default */
        }



        .weather-overlay {
            position: absolute;
            /* Memungkinkan elemen untuk diposisikan relatif terhadap kontainer */
            top: 10px;
            /* Jarak dari bagian atas kontainer */
            left: 10px;
            /* Jarak dari sisi kiri kontainer */
            z-index: 10;
            /* Pastikan elemen ini muncul di atas gambar */
            padding: 4px;
            /* Mengurangi padding lebih lanjut untuk memperkecil ukuran kotak */
            border-radius: 4px;
            /* Mengurangi border radius */
            background-color: rgba(181, 179, 179, 0.8);
            /* Menambahkan latar belakang dengan transparansi */
            font-size: 0.8rem;
            /* Mengurangi ukuran font untuk membuat kotak lebih kecil */
        }








        #weather-detail {
            margin-top: 1rem;
        }

        .image-container {
            position: relative;
            /* Membuat kontainer menjadi relative agar anak-anaknya dapat diposisikan absolut */
        }

        /* Style untuk garis pemisah antar kecamatan */
        .kecamatan-divider {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 20px;
        }

        .marker-label {
            color: black;
            background-color: white;
            top: 45px;
        }

        .toggle-link {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            border: none;
            background: none;
            padding: 0;
            font-family: inherit;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1001;
            cursor: pointer;
        }

        .toggle-link:hover {
            text-decoration: none;
        }


        .controlsembunyi {
            position: absolute;
            border-radius: 4px;
            padding: 2px 6px;
            top: 50px;
            right: 50px;
            padding: 10px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 600;

        }

        .controlmap {

            position: absolute;
            font-size: 12px;
            border-radius: 4px;
            padding: 2px 6px;
            top: 40px;
            right: 40px;
            background-color: white;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 500;

        }

        .toggle-link {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }

        .toggle-link:hover {
            text-decoration: none;
        }

        .gambarcard {
            height: 200px;
            object-fit: cover;
        }


        /* Gaya untuk card yang tersembunyi */
        .hidden {
            display: none;
        }

        /* Gaya untuk card yang ditampilkan */
        .visible {
            display: block;
            /* Atau tata letak yang sesuai */
        }


        .card-text {
            white-space: pre-wrap;
            /* Menghormati spasi putih dan garis baru */
        }

        .card-img-top {
            height: 150px;
            object-fit: cover;
        }

        .gambarcard {
            height: 300px;
            object-fit: cover;
        }

        .map-mode-buttons {
            display: flex;
            gap: 10px;
        }



        .search-container {
            position: absolute;
            top: 10px;
            border-radius: 50px;
            left: 50px;
            z-index: 1;
            width: 300px;
        }

        .form-control {
            padding: 5px;
            font-size: 16px;
        }


        .directions-panel {
            position: absolute;
            top: 200px;
            left: 50px;
            z-index: 1;
            width: 30 0px;
        }

        /* Sembunyikan konten secara default */
        .content.hidden {
            display: none;
        }


        .zoom-controls {
            position: absolute;
            z-index: 1000;
            /* Tetap di atas layer lainnya */
            top: 60px;
            /* Posisi top */
            left: 50px;
            /* Posisi dari kanan */
            background-color: white;
            padding: 5px;
            /* Padding lebih kecil */
            border-radius: 3px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            width: 300px;
            /* Lebar lebih kecil */
        }

        /* Panel petunjuk arah */
        #directionsPanel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            max-height: 40vh;
            overflow-y: auto;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.2);
            z-index: 10;
            transition: max-height 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .navbar-nav .nav-link.active {
            background-color: #007bff;
            /* Warna background khusus tombol aktif */
            color: white;
            /* Warna teks pada tombol aktif */
            border-radius: 5px;
            /* Memberikan sedikit rounded pada tombol aktif */
        }

        .navbar-nav .nav-link:hover {
            background-color: #0056b3;
            /* Warna saat hover */
            color: white;
            border-radius: 5px;
        }

        .navbar-nav .nav-link {
            color: #333;
            /* Warna default tombol lainnya */
        }

  

        /* Tombol minimize atau hide panel */
        /* Sembunyikan tombol secara default */
        #toggleDirections {
            display: none;
            /* Tombol disembunyikan */
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #3887be;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 11;
        }


        /* Panel yang disembunyikan (slide-down keluar layar) */
        .hidden-panel {
            transform: translateY(100%);
            /* Geser ke luar layar */
        }


        @media screen and (max-width: 844px){
            .weather-overlay {
                display: none;
            }
        }


        @media screen and (max-width: 1193px) {

            
            #directionsList li {
                font-size: 0.9rem;
                padding: 8px 12px;
            }

            .toggle-button {
                position: absolute;
                cursor: pointer;
                display: inline-block;
                margin-bottom: 10px;
                right: 10px;
                top: 150px;
            }


            .search-container {
                position: absolute;
                top: 10px;
                border-radius: 50px;
                left: 50px;
                z-index: 1;
                width: 250px;
            }

            .controlmap {

                position: absolute;
                font-size: 12px;
                border-radius: 4px;
                padding: 2px 6px;
                top: 140px;
                right: 1px;
                background-color: white;
                padding: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                z-index: 500;

            } */

    



            #directionsPanel {
                max-height: 30vh;
                /* Sesuaikan ketinggian */
            }

            .zoom-controls {
                display: none;
            }

            #filter-buttons {
                display: flex !important;
                flex-wrap: wrap !important;
                /* Memungkinkan elemen untuk membungkus ke baris berikutnya */
                gap: 3px !important;
                margin-bottom: 15px !important;
            }

            .btn-filter {
                position: relative !important;
                padding: 3px 10px !important;
                background-color: white !important;
                border: 1px solid #ccc !important;
                border-radius: 25px !important;
                cursor: pointer !important;
                transition: background-color 0.3s ease !important;
                left: 10px !important;
                top: 70px !important;
                z-index: 1000 !important;
                font-size: 10px !important;
                /* Ukuran font lebih kecil */
            }

            .btn-filter:hover {
                background-color: #f0f0f0 !important;
            }

            #filter-buttons {
                display: flex !important;
                gap: 3px !important;
                margin-bottom: 15px !important;
            }

        }



        .btn-filter.active {
            background-color: blue;
            color: white;
        }



        #filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;

        }

        .btn-filter {
            position: relative;
            padding: 8px 12px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            left: 370px;
            top: 10px;
            z-index: 1000 !important;
        }

        .btn-filter:hover {
            background-color: #f0f0f0;
        }

        #toggleCard {
            width: 300px;
            /* Batasi lebar agar elemen terlihat lebih proporsional */
            padding: 15px;
            /* Berikan padding di dalam container */
            background-color: #ffffff;
            /* Tambahkan warna background yang jelas */
            border-radius: 8px;
            /* Tambahkan sudut melengkung untuk tampilan yang lebih baik */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Berikan shadow agar lebih menarik */
        }

        .form-check {
            margin-bottom: 10px;
            /* Berikan jarak antar checkbox */
        }

        h5 {
            margin-bottom: 8px;
            /* Tambahkan jarak antar judul kecamatan dan checkbox */
        }

        .controlmap {
            margin: 10px;
            /* Tambahkan margin luar agar tidak terlalu mepet dengan elemen lain */
        }

        h4,
        h5,
        label {
            font-weight: bold;
            /* Perjelas teks dengan bold */
        }

        .form-check-label {
            margin-left: 5px;
            /* Jarak antara checkbox dan teks label */
        }

        .text-center {
            margin-top: 20px;
            /* Tambahkan jarak atas untuk elemen "Pilih Mode Peta" */
        }

        .btn {
            margin: 5px;
            /* Berikan jarak antar tombol */
        }

        #toggleCard {
            width: 320px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h4,
        h5 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 12px;
        }

        .form-check {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .form-check-label {
            margin-left: 10px;
            font-size: 1.1rem;
            color: #495057;
        }

        .form-check-input {
            width: 24px;
            height: 24px;
        }

        .text-center .btn {
            border-radius: 20px;
            font-size: 0.9rem;
            padding: 8px 16px;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .text-center .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .text-center .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .text-center .btn:hover {
            background-color: #0056b3;
        }

        /* Custom Toggle Switch for Labels */
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            border-radius: 50%;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        /* Circle Bullet for Kecamatan List */
        .form-check-input {
            appearance: none;
            background-color: #fff;
            border: 2px solid #ced4da;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .kontak-kami {
            text-align: center;
            padding: 20px;
        }

        .kontak-kami h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .social-media a {
            margin: 0 10px;
        }

        .social-media img {
            width: 40px;
            /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
            transition: transform 0.2s;
        }

        .social-media img:hover {
            transform: scale(1.1);
            /* Efek hover untuk logo */
        }

        .equal-height {
            height: 150px;
            /* Atur tinggi yang diinginkan */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>

<body style="background-color: #FAF7F0p">

    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "{{ session('success') }}",

            });
        </script>
    @endif

    @if (session('failed'))
        <script>
            Swal.fire({
                icon: "error",
                title: "gagalll",
                text: "{{ session('failed') }}",

            });
        </script>
    @endif

    <nav class="navbar navbar-expand-md sticky-top navbar-shrink py-3" style="background-color: #15B392;"
        id="mainNav">
        <div class="container"> <a class="navbar-brand d-flex align-items-center" href="/">
                <span
                    class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="40" height="40">
                </span>
                <span>SIG Wisata Banjarmasin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navcol-1"
                aria-controls="navcol-1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-1 p-1">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Tentang Kami    
                        </a>
                    </li>
                    <li class="nav-item mx-1 p-1 ">
                        <a class="nav-link {{ request()->routeIs('map.show', 'normal') ? 'active' : '' }}"
                            href="{{ route('map.show', 'normal') }}">
                            <i class="fas fa-map"></i> Peta
                        </a>
                    </li>
                    <li class="nav-item mx-1 p-1">
                        <a class="nav-link {{ request()->routeIs('card.index') ? 'active' : '' }}"
                            href="{{ route('card.index', ['map' => 'normal']) }}">
                            <i class="fas fa-database"></i> Data Wisata
                        </a>
                    </li>
                    <li class="nav-item mx-1 p-1">
                        <a class="nav-link {{ request()->routeIs('statistik') ? 'active' : '' }}"
                            href="{{ route('statistik') }}">
                            <i class="fas fa-chart-bar"></i> Statistik Wisata
                        </a>
                    </li>
                    @if (Auth::guard('admin')->check())
                        <li class="nav-item mx-1 p-1">
                            <a class="nav-link {{ request()->routeIs('data.show') ? 'active' : '' }}"
                                href="{{ route('data.show') }}">
                                <i class="fas fa-edit"></i> Kelola Data Wisata
                            </a>
                        </li>
                        <li class="nav-item mx-1 p-1">
                            <a class="nav-link {{ request()->routeIs('geojson.index') ? 'active' : '' }}"
                                href="{{ route('geojson.index') }}">
                                <i class="fas fa-draw-polygon"></i> Kelola Batas Wilayah
                            </a>
                        </li>
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    @endif
                    @guest('admin')
                        <a class="btn btn-primary shadow" role="button" href="{{ route('admin.login') }}">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                    @endguest
                </ul>
            </div>


        </div>
    </nav>



    <div class="">
        @yield('content')
    </div>


    <!-- Footer -->
    <br>
    <br>
    <footer class="bg-primary-gradient">
        <hr>
        <div class="container text-muted d-flex flex-column align-items-center pt-3">
            <p class="mb-0">Copyright © 2024 Mulidani</p>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a href="https://web.facebook.com/mulidani.dani.3" target="_blank" class="d-block mb-3">
                        <img src="https://img.icons8.com/?size=100&id=118497&format=png&color=000000" alt="Facebook"
                            style="width: 40px; height: 40px;">
                        <span>Facebook</span>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="https://x.com/Mulidani4" target="_blank" class="d-block mb-3">
                        <img src="https://img.icons8.com/?size=100&id=13963&format=png&color=000000" alt="Twitter"
                            style="width: 40px; height: 40px;">
                        <span>Twitter</span>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="https://www.instagram.com/md_dani30/" target="_blank" class="d-block mb-3">
                        <img src="https://img.icons8.com/?size=100&id=32323&format=png&color=000000" alt="Instagram"
                            style="width: 40px; height: 40px;">
                        <span>Instagram</span>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="https://www.youtube.com/@mulidani8753" target="_blank" class="d-block mb-3">
                        <img src="https://img.icons8.com/?size=100&id=19318&format=png&color=000000" alt="YouTube"
                            style="width: 40px; height: 40px;">
                        <span>YouTube</span>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="https://wa.me/085753206159" target="_blank" class="d-block mb-3">
                        <img src="https://img.icons8.com/?size=100&id=16713&format=png&color=000000" alt="WhatsApp"
                            style="width: 40px; height: 40px;">
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    <!-- End Footer -->

    <!-- Additional scripts -->
    {{-- <script src="{{ asset('') }}assets/bootstrap/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('') }}assets/js/script.min.js"></script>

    @yield('scripts')


</body>

</html>
