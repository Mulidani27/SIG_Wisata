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
        <div class="mb-3">
            <label for="kota" class="form-label">Pilih Kota</label>
            <select class="form-control" id="kota" name="kota" required>
                <option value="">Pilih Kota</option>
                @foreach($kotas as $kota)
                    <option value="{{ $kota->id }}" {{ $kecamatan->kota->id == $kota->id ? 'selected' : '' }}>
                        {{ $kota->kota }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="batas_timur" class="form-label">Batas Timur</label>
            <input type="text" class="form-control" id="batas_timur" name="batas_timur" value="{{ $kecamatan->batas_timur }}" required>
        </div>
        <div class="mb-3">
            <label for="batas_barat" class="form-label">Batas Barat</label>
            <input type="text" class="form-control" id="batas_barat" name="batas_barat" value="{{ $kecamatan->batas_barat }}" required>
        </div>
        <div class="mb-3">
            <label for="batas_selatan" class="form-label">Batas Selatan</label>
            <input type="text" class="form-control" id="batas_selatan" name="batas_selatan" value="{{ $kecamatan->batas_selatan }}" required>
        </div>
        <div class="mb-3">
            <label for="batas_utara" class="form-label">Batas Utara</label>
            <input type="text" class="form-control" id="batas_utara" name="batas_utara" value="{{ $kecamatan->batas_utara }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
