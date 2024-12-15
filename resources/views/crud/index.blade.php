@extends('app')

@section('title', 'Data Wisata')

@section('content')
<div class="container">
    <br>
    <br>
    
    <h1>Daftar Wisata</h1>
    <br>
    <a href="{{ route('crud.create') }}" class="btn btn-success">Tambah Wisata</a>
    <br>
    <br>

    <table id="tableWisata" class="table table-striped">
        <thead>
            <tr>
                <th>No</th> <!-- Kolom nomor urut -->
                <th>Nama Wisata</th>
                <th>Koordinat</th>
                <th>Alamat</th>
                <th>Jenis Wisata</th>
                <th>Detail</th>
                <th>Kecamatan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wisata as $key => $wisataItem)
            <tr>
                <td>{{ $key + 1 }}</td> <!-- Nomor urut sesuai dengan iterasi -->
                <td>{{ $wisataItem->Nama_Wisata }}</td>
                <td>{{ Str::limit($wisataItem->lokasi, 20) }}</td>
                <td>{{ Str::limit($wisataItem->Alamat, 30) }}</td>
                <td>{{ Str::limit($wisataItem->Jenis_Wisata, 20) }}</td>
                <td>{!! Str::limit($wisataItem->Detail, 50) !!}</td>
                <td>{{ $wisataItem->kecamatan["nama_kecamatan"] }}</td>
                <td>
                    <!-- Tombol Edit dengan ikon -->
                    <a href="{{ route('crud.edit', $wisataItem->id) }}" class="btn  btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                
                    <!-- Tombol Delete dengan ikon -->

                    
                    <form action="{{ route('crud.destroy', $wisataItem->id) }}" method="POST" style="display:inline-block;" id="delete-form-{{ $wisataItem->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $wisataItem->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    
                    <script>
                        function confirmDelete(id) {
                            Swal.fire({
                                title: 'Yakin ingin menghapus?',
                                text: 'Data yang dihapus tidak dapat dikembalikan!',
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
                    



                    <!-- Tombol Kelola Komentar -->
                    <a href="{{ route('komentar.manage', $wisataItem->id) }}" class="btn btn-info">
                        <i class="fas fa-comments"></i> 
                    </a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableWisata').DataTable();
    });
</script>
@endsection
