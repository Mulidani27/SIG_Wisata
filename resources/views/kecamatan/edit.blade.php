@extends('app')

@section('content')
<div class="container">
    <h1>Edit Kecamatan</h1>
    <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_kecamatan" class="form-label">Nama Kecamatan</label>
            <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan" value="{{ $kecamatan->nama_kecamatan }}" required>
        </div>
        <div class="mb-3">
            <label for="kantor_kecamatan" class="form-label">Kantor Kecamatan</label>
            <input type="text" class="form-control" id="kantor_kecamatan" name="kantor_kecamatan" value="{{ $kecamatan->kantor_kecamatan }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
