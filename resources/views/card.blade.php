@extends('app')

@section('title', 'Data Wisata')

@section('content')
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($wisata as $wisataItem)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('uploads/' . $wisataItem->Gambar) }}" class="gambarcard" alt="{{ $wisataItem->Nama_Wisata }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $wisataItem->Nama_Wisata }}</h5>
                        <p class="card-text" id="shortDetail{{ $loop->index }}">{{ \Illuminate\Support\Str::words($wisataItem->Detail, 10) }}...</p>
                        <p class="card-text" id="fullDetail{{ $loop->index }}" style="display: none;">{{ $wisataItem->Detail }}</p>
                        <a href="javascript:void(0)" class="toggle-link" id="toggleButton{{ $loop->index }}" onclick="toggleDetail({{ $loop->index }})">Lihat Selengkapnya</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Alamat: {{ $wisataItem->Alamat }}</li> <!-- Menampilkan alamat -->
                        <li class="list-group-item">Jenis Wisata: {{ $wisataItem->Jenis_Wisata }}</li>
                    </ul>
                    <div class="card-body">
                        <a href="{{ route('map.view', $wisataItem->id) }}" class="card-link">Lihat Gambar 360</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function toggleDetail(index) {
            const shortDetail = document.getElementById('shortDetail' + index);
            const fullDetail = document.getElementById('fullDetail' + index);
            const toggleButton = document.getElementById('toggleButton' + index);

            if (shortDetail.style.display === 'none') {
                shortDetail.style.display = 'block';
                fullDetail.style.display = 'none';
                toggleButton.textContent = 'Lihat Selengkapnya';
            } else {
                shortDetail.style.display = 'none';
                fullDetail.style.display = 'block';
                toggleButton.textContent = 'Sembunyikan';
            }
        }
    </script>
@endsection

@section('styles')
    <style>
        .toggle-link {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }

        .toggle-link:hover {
            text-decoration: none;
        }

        .gambarcard {
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
