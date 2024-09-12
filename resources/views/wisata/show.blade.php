@extends('app')

@section('content')
<div class="container mt-5">
    <h1>{{ $wisata->nama }}</h1>

    <!-- Form untuk menambah komentar dan rating -->
    <div class="card mt-4">
        <div class="card-body">
            <h4>Tambah Komentar dan Rating</h4>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('komentars.store', $wisata->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
                </div>
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar</label>
                    <textarea name="komentar" id="komentar" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>

    <!-- Daftar Komentar dan Rating -->
    <div class="mt-5">
        <h4>Komentar Pengguna</h4>
        @foreach($komentars as $komentar)
            <div class="card mt-3">
                <div class="card-body">
                    <strong>{{ $komentar->nama }}</strong>
                    <span class="badge bg-info">{{ $komentar->rating }} / 5</span>
                    <p>{{ $komentar->komentar }}</p>
                    <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
