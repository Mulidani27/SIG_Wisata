@extends('app')

@section('title', 'Data Wisata')

@section('content')

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($wisata as $wisataItem)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/' . $wisataItem->Gambar) }}" class="card-img-top" alt="{{ $wisataItem->Nama_Wisata }}">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $wisataItem->Nama_Wisata }}</h5>
                        <p class="card-text">{{ $wisataItem->Detail }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Lokasi: {{ $wisataItem->lokasi }}</li>
                        <li class="list-group-item">Jenis Wisata: {{ $wisataItem->Jenis_Wisata }}</li>
                    </ul>
                    <div class="card-body">
                        <a href="{{ route('map.view', $wisataItem->id) }}" class="card-link">Lihat Gambar 360</a>
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>

@endsection
