@extends('app')

@section('content')
    <div class="container mt-5">
        <h1>Kelola Batas Wilayah</h1>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Upload GeoJSON -->
        <form action="{{ route('geojson.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="geojson" class="form-label">Unggah File GeoJSON</label>
                <input class="form-control" type="file" name="geojson" id="geojson" accept=".geojson" required>
            </div>
            <div class="mb-3">
                <label for="namaWilayah" class="form-label">Nama Wilayah</label>
                <input class="form-control" type="text" name="namaWilayah" id="namaWilayah" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>

        <!-- Daftar Batas Wilayah -->
        <h2 class="mt-5">Daftar Batas Wilayah</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Wilayah</th>
                    <th>File GeoJSON</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($geojsons as $geojson)
                    <tr>
                        <td>{{ $geojson->nama_wilayah }}</td>
                        <td>
                            <a href="{{ asset('uploads/' . $geojson->geojson) }}" download>
                                {{ $geojson->geojson }}
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('geojson.delete', $geojson->id) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $geojson->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $geojson->id }})">
                                    Hapus
                                </button>
                            </form>
                            
                            <script>
                                function confirmDelete(id) {
                                    Swal.fire({
                                        title: 'Yakin ingin menghapus?',
                                        text: 'Data ini akan dihapus secara permanen!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Jika konfirmasi, submit form
                                            document.getElementById('delete-form-' + id).submit();
                                        }
                                    });
                                }
                            </script>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
