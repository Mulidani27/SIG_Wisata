@extends('app')

@section('content')
    <h1 class="mb-4">Daftar Kota</h1>
    <a href="{{ route('kota.create') }}" class="btn btn-primary mb-3">Tambah Kota</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Kota</th>
                    <th>Kantor Kota</th>
                    <th>Batas Timur</th>
                    <th>Batas Barat</th>
                    <th>Batas Selatan</th>
                    <th>Batas Utara</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kotas as $kota)
                    <tr>
                        <td>{{ $kota->kota }}</td>
                        <td>{{ $kota->kantor_kota }}</td>
                        <td>{{ $kota->batas_timur }}</td>
                        <td>{{ $kota->batas_barat }}</td>
                        <td>{{ $kota->batas_selatan }}</td>
                        <td>{{ $kota->batas_utara }}</td>
                        <td>
                            <a href="{{ route('kota.edit', $kota) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form id="delete-form-{{ $kota->id }}" action="{{ route('kota.destroy', $kota) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $kota->id }})">Hapus</button>
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
