@extends('app')

@section('title', 'Kelola Komentar')

@section('content')
<div class="container">
    <br>
    <h1>Kelola Komentar untuk Wisata: {{ $wisata->Nama_Wisata }}</h1>
   

    <br><br>

    <h3>Daftar Komentar</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Komentar</th>
                <th>Rating</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($komentars as $key => $komentar)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $komentar->komentar }}</td>
                <td>{{ $komentar->rating }}</td>
                <td>
                    <!-- Tombol Hapus Komentar -->
                    <form action="{{ route('komentar.destroy', $komentar->id) }}" method="POST" style="display: inline-block" id="delete-form-{{ $komentar->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $komentar->id }})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    
                    <script>
                        function confirmDelete(id) {
                            Swal.fire({
                                title: 'Yakin ingin menghapus komentar?',
                                text: 'Komentar yang dihapus tidak dapat dikembalikan!',
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
