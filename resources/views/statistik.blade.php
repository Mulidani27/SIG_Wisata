@extends('app')

@section('title', 'Data Wisata')

@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Statistik Wisata</h1>

    <div class="row">
        <!-- Kolom 1 -->
        <div class="col-md-6">
            <!-- Statistik Jumlah Wisata Berdasarkan Jenis -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Jumlah Wisata Berdasarkan Jenis
                </div>
                <div class="card-body">
                    <canvas id="jenisWisataChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Kolom 2 -->
        <div class="col-md-6">
            <!-- Statistik Jumlah Wisata per Kecamatan -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    Jumlah Wisata per Kecamatan
                </div>
                <div class="card-body">
                    <canvas id="kecamatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data Statistik Jenis Wisata
    const jenisWisataData = {
        labels: @json($jenisWisataCounts->pluck('Jenis_Wisata')),
        datasets: [{
            label: 'Jumlah',
            data: @json($jenisWisataCounts->pluck('count')),
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6c757d', '#17a2b8', '#343a40'],
        }]
    };

    // Data Statistik Kecamatan
    const kecamatanData = {
        labels: @json($kecamatanCounts->pluck('kecamatan')),
        datasets: [{
            label: 'Jumlah',
            data: @json($kecamatanCounts->pluck('count')),
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6c757d', '#17a2b8', '#343a40'],
        }]
    };

    // Render Charts
    new Chart(document.getElementById('jenisWisataChart'), {
        type: 'bar',
        data: jenisWisataData,
    });

    new Chart(document.getElementById('kecamatanChart'), {
        type: 'bar',
        data: kecamatanData,
    });
</script>


@endsection
