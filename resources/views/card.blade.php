@extends('app')

@section('title', 'Data Wisata')

@section('content')
<div class="container">
    <div class="mb-3">
        <br>
        <br>
        <form action="{{ route('wisata.index') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari Nama Wisata..." name="query" value="{{ request('query') }}">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
        </form>
    </div>

    @php
        $groupedWisata = $wisata->groupBy('kecamatan_id'); // Mengelompokkan berdasarkan kecamatan_id
    @endphp

    @foreach($groupedWisata as $kecamatanId => $wisataGroup)
        @php
            // Menemukan nama kecamatan berdasarkan kecamatan_id
            $kecamatan = $wisataGroup->first()->kecamatan; // Mendapatkan kecamatan dari wisata pertama di grup
        @endphp

        <div class="kecamatan-divider">
            <h1 style="text-align: center">{{ $kecamatan->nama_kecamatan }}</h1>
            <br>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($wisataGroup as $index => $wisataItem)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('uploads/' . $wisataItem->Gambar) }}" class="gambarcard" alt="{{ $wisataItem->Nama_Wisata }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $wisataItem->Nama_Wisata }}</h5>
                                <p class="card-text" id="shortDetail{{ $loop->parent->index }}-{{ $index }}">{{ \Illuminate\Support\Str::words($wisataItem->Detail, 10) }}...</p>
                                <p class="card-text" id="fullDetail{{ $loop->parent->index }}-{{ $index }}" style="display: none;">{{ $wisataItem->Detail }}</p>
                                <a href="javascript:void(0)" class="toggle-link" id="toggleButton{{ $loop->parent->index }}-{{ $index }}" onclick="toggleDetail('{{ $loop->parent->index }}-{{ $index }}')">Lihat Selengkapnya</a>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Alamat: {{ $wisataItem->Alamat }}</li>
                                <li class="list-group-item">Jenis Wisata: {{ $wisataItem->Jenis_Wisata }}</li>
                            </ul>
                        <div class="d-flex justify-content-center">
                        <a class="btn btn-primary" href="{{route("map.view",$wisataItem->id)}}" role="button">Lihat Gambar 360</a>
                        </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    
    @endforeach

    <script>
        function toggleDetail(id) {
            const shortDetail = document.getElementById('shortDetail' + id);
            const fullDetail = document.getElementById('fullDetail' + id);
            const toggleButton = document.getElementById('toggleButton' + id);

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

</div> 
@endsection
