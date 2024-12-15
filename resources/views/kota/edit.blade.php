@extends('app')

@section('content')
    <h1>Edit Kota</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('kota.update', $kota->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">

        <div class="mb-3">
            <label for="kota" class="form-label">Nama Kota</label>
            <input type="text" class="form-control" id="kota" name="kota" value="{{ old('kota', $kota->kota) }}" required>
        </div>

        <div class="mb-3">
            <label for="kantor_kota" class="form-label">Kantor Kota</label>
            <input type="text" class="form-control" id="kantor_kota" name="kantor_kota" value="{{ old('kantor_kota', $kota->kantor_kota) }}" required>
        </div>

        <div class="mb-3">
            <label for="batas_timur" class="form-label">Batas Timur</label>
            <input type="text" class="form-control" id="batas_timur" name="batas_timur" value="{{ old('batas_timur', $kota->batas_timur) }}" required>
        </div>

        <div class="mb-3">
            <label for="batas_barat" class="form-label">Batas Barat</label>
            <input type="text" class="form-control" id="batas_barat" name="batas_barat" value="{{ old('batas_barat', $kota->batas_barat) }}" required>
        </div>

        <div class="mb-3">
            <label for="batas_selatan" class="form-label">Batas Selatan</label>
            <input type="text" class="form-control" id="batas_selatan" name="batas_selatan" value="{{ old('batas_selatan', $kota->batas_selatan) }}" required>
        </div>

        <div class="mb-3">
            <label for="batas_utara" class="form-label">Batas Utara</label>
            <input type="text" class="form-control" id="batas_utara" name="batas_utara" value="{{ old('batas_utara', $kota->batas_utara) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
    

@endsection
