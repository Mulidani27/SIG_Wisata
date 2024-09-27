@extends('app')

@section('title', 'Data Wisata')

@section('content')
<div class="container">
    <br>
    <br>
    
    <h1>Daftar Wisata</h1>
    <br>
    <a href="{{ route('crud.create') }}" class="btn btn-success">Tambah Wisata</a>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

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
                <td>{{ $wisataItem->kecamatan }}</td>
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
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableWisata').DataTable();
    });
</script>
@endsection
