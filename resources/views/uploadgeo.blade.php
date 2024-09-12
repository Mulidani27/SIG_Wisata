@extends('app')

@section('title', 'Data Wisata')

@section('content')

<form action="{{ route('upload.geojson') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="geojsonFile" class="form-label">Unggah File GeoJSON</label>
        <input class="form-control" type="file" name="geojsonFile" id="geojsonFile" accept=".geojson" required>
    </div>
    <div class="mb-3">
        <label for="namaWilayah" class="form-label">Nama Daerah</label>
        <input class="form-control" type="text" name="namaWilayah" id="namaWilayah" required>
    </div>
    <button type="submit" class="btn btn-primary">Unggah</button>
</form>


@endsection