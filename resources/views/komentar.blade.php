<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Form Komentar</h1>
        <form action="{{ route('komentar.kirim') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama">
            </div>
            <div class="form-group">
                <label for="komentar">Komentar:</label>
                <textarea class="form-control" id="komentar" name="komentar" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>

        <hr>

        <h1>Daftar Komentar</h1>
        <ul class="list-group">
            @foreach($komentars as $komentar)
                <li class="list-group-item">
                    <strong>Nama:</strong> {{ $komentar->nama }} <br>
                    <strong>Komentar:</strong> {{ $komentar->komentar }}
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
