<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image 360 Viewer</title>
    <link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="panorama" style="width: 100%; height: 500px;"></div>
    <!-- Tombol Kembali menggunakan Bootstrap -->
    <button class="btn btn-primary back-button" onclick="goBack()">Kembali</button>
    <script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>
    <script>
        var panorama;
            
        panorama = pannellum.viewer('panorama', {
            "type": "equirectangular",
            "panorama": "{{ asset('assets/images/'.$wisata->gambar360)}}",
            "autoLoad": true
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
