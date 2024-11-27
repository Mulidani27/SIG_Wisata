@extends('app')

@section('content')
<div class="container">
    <h1>Daftar Kecamatan</h1>
    <a href="{{ route('kecamatan.create') }}" class="btn btn-primary mb-3">Tambah Kecamatan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kecamatan</th>
                <th>Kantor Kecamatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kecamatans as $kecamatan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kecamatan->nama_kecamatan }}</td>
                <td>{{ $kecamatan->kantor_kecamatan }}</td>
                <td>
                    <a href="{{ route('kecamatan.edit', $kecamatan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kecamatan.destroy', $kecamatan->id) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $kecamatan->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $kecamatan->id }})">
                            Delete
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
