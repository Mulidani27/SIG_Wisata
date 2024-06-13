@extends('app')

@section('title', 'Data Wisata')

@section('content')
<div class="container">
    <h1>Daftar Wisata</h1>
    <br>
    <a href="{{ route('crud.create') }}" class="btn btn-success">Tambah Wisata</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Wisata</th>
                <th>Koordinat</th>
                <th>Alamat</th>
                <th>Jenis Wisata</th>
                <th>Detail</th>
                <th>Kecamatan</th> <!-- Tambah kolom kecamatan -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wisata as $wisataItem)
            <tr>
                <td>{{$wisataItem->Nama_Wisata }}</td>
                <td>{{ Str::limit($wisataItem->lokasi) }}</td>
                <td>{{ Str::limit($wisataItem->Alamat, 20) }}</td>
                <td>{{ Str::limit($wisataItem->Jenis_Wisata, 10) }}</td>
                <td>{!! Str::limit($wisataItem->Detail, 30) !!}</td>
                <td>{{ $wisataItem->kecamatan }}</td> <!-- Menampilkan kecamatan -->

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
