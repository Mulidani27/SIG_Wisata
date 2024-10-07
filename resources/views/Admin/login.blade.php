<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 150px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');

            emailInput.addEventListener('input', function() {
                const atIndex = emailInput.value.indexOf('@');
                if (atIndex !== -1 && !emailInput.value.endsWith('@gmail.com')) {
                    emailInput.value = emailInput.value.substring(0, atIndex + 1) + 'gmail.com';
                }
            });

            // Mapbox setup
            mapboxgl.accessToken = 'pk.eyJ1IjoieW9naWUzNTM2IiwiYSI6ImNsbGl5aWk1azFpb24zcXBrM2J6d2ZtemsifQ.Qsp6yejel2SIY6LWKweTBA';
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [114.5914681, -3.3154437], // Contoh koordinat
                zoom: 12
            });

            // Aktifkan interaksi panning, zooming, dan lainnya
            map.scrollZoom.enable();
            map.dragPan.enable();
            map.boxZoom.enable();
            map.dragRotate.enable();
            map.keyboard.enable();
            map.doubleClickZoom.enable();
            map.touchZoomRotate.enable();
        });
    </script>
</head>
<body>

<div id="map"></div> <!-- Mapbox background -->

<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6">
        <div class="card login-container">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo"> <!-- Logo -->

            <div class="card-header text-center">
                <h3>Login Admin</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/admin/login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                    <!-- Tampilkan error jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </form>

                <!-- Tombol Kembali -->
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-secondary" onclick="history.back()">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mapbox JS -->
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

</body>
</html>
