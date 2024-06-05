<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wisata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Daftar Wisata</h1>
        <br>
        <a href="{{ route('crud.create') }}" class="btn btn-success">Tambah Wisata</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Wisata</th>
                    <th>Lokasi</th>
                    <th>Jenis Wisata</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wisata as $wisataItem)
                <tr>
                    <td>{{ $wisataItem->Nama_Wisata }}</td>
                    <td>{{ $wisataItem->lokasi }}</td>
                    <td>{{ $wisataItem->Jenis_Wisata }}</td>
                    <td>{{ Str::limit($wisataItem->Detail, 50) }}</td>
                    <td>
                        <a href="{{ route('crud.edit', $wisataItem->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('crud.destroy', $wisataItem->id) }}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
