@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* ... (CSS yang sudah ada) ... */
        .who-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .who-table th, .who-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }
        .who-table thead {
            background-color: #f0f0f0;
        }
        .who-table tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        .highlight-row {
            background-color: #d1ecf1 !important; /* Warna untuk baris data balita di tabel WHO */
            font-weight: bold;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        /* Style untuk container grafik */
        .chart-container {
            position: relative;
            height: 400px; /* Sesuaikan tinggi grafik sesuai kebutuhan */
            width: 100%;
            margin-top: 20px;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
@endpush

@section('title', 'Detail Pertumbuhan ' . $balita->nama)
@section('judul', 'Detail Pertumbuhan ' . $balita->nama)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            @can('post-admin')
            <div class="page-header">
                <h1 class="m-0">Detail Rekap Pertumbuhan {{ $balita->nama }}</h1>
                <a href="{{ route('admin.pertumbuhananak') }}" class="btn btn-secondary">Kembali ke Rekap Umum</a>
            </div>
            @endcan
            @can('post-bidan')
            <div class="page-header">
                <h1 class="m-0">Detail Rekap Pertumbuhan {{ $balita->nama }}</h1>
                <a href="{{ route('bidan.pertumbuhananak') }}" class="btn btn-secondary">Kembali ke Rekap Umum</a>
            </div>
            @endcan
            @can('post-ortu')
            <div class="page-header">
                <h1 class="m-0">Detail Rekap Pertumbuhan {{ $balita->nama }}</h1>
                <a href="{{ route('ortu.pertumbuhananak') }}" class="btn btn-secondary">Kembali ke Rekap Umum</a>
            </div>
            @endcan
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Bagian Grafik Tinggi Badan --}}
            <h4>Grafik Tinggi Badan per Usia (TB/U)</h4>
            <div class="chart-container">
                <canvas id="heightForAgeChart"></canvas>
            </div>

            <hr class="my-4">

            <h4>Data Pengukuran Balita</h4>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Pengukuran</th>
                        <th>Usia (bulan)</th>
                        <th>BB (kg)</th>
                        <th>TB (cm)</th>
                        <th>IMT</th>
                        <th>Lingkar Kepala</th>
                        <th>Status Stunting (TB/U)</th>
                        <th>Hasil Diagnosis (Stunting)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapData as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $data->usia }}</td>
                            <td>{{ $data->bb }}</td>
                            <td>{{ $data->tb }}</td>
                            <td>{{ number_format($data->imt, 2) }}</td>
                            <td>{{ $data->lingkar_kepala }}</td>
                            {{-- Gunakan $data->calculated_status_gizi atau $data->status_gizi untuk TB/U --}}
                            <td>{{ $data->calculated_status_gizi ?? $data->status_gizi }}</td>
                            <td>{{ $data->calculated_diagnosis_description ?? $data->hasil_diagnosis }}</td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Colspan disesuaikan dengan jumlah kolom yang tersisa (8 kolom) --}}
                            <td colspan="8">Belum ada data pengukuran untuk balita ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <hr class="my-4">

            <h4>Standar Tinggi Badan per Usia (TB/U) WHO untuk {{ $balita->jenis_kelamin }}</h4>
            {{-- Pastikan nama variabel ini sesuai dengan yang dikirim dari controller --}}
            @if (!empty($selectedWhoStandardHeight))
                <table class="who-table">
                    <thead>
                        <tr>
                         {{-- sangat pendek, pendek, normal, tinggi, sangat tinggi --}}
                            <th>Usia (bulan)</th>
                            <th>P3 (-2.5 SD)</th>
                            <th>P15 (-1 SD)</th>
                            <th>P50 (Median)</th>
                            <th>P85 (+1 SD)</th>
                            <th>P97 (+2.5 SD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedWhoStandardHeight as $standard)
                            @php
                                $isHighlight = false;
                                foreach ($rekapData as $data) {
                                    if (round($data->usia) == round($standard['usia'])) {
                                        $isHighlight = true;
                                        break;
                                    }
                                }
                            @endphp
                            <tr class="{{ $isHighlight ? 'highlight-row' : '' }}">
                                <td>{{ $standard['usia'] }}</td>
                                {{-- Nilai tinggi badan pada persentil 3. --}}
                                <td>{{ number_format($standard['3rd'], 2) }}</td>  
                                <td>{{ number_format($standard['15th'], 2) }}</td>
                                <td>{{ number_format($standard['median'], 2) }}</td>
                                <td>{{ number_format($standard['85th'], 2) }}</td>
                                <td>{{ number_format($standard['97th'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Data standar WHO untuk jenis kelamin {{ $balita->jenis_kelamin }} tidak ditemukan.</p>
            @endif

        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> {{-- Sertakan Chart.js --}}

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        // --- Grafik Tinggi Badan per Usia (TB/U) ---
        const ctxHeight = document.getElementById('heightForAgeChart').getContext('2d');
        
        const rekapData = @json($rekapData); //mengubah php ke js
        const whoStandardsHeight = @json($selectedWhoStandardHeight); //mengubah standar who menjadi js

        let minUsia = 0;
        let maxUsia = 60; // Default WHO max age
        if (rekapData.length > 0) {
            minUsia = Math.min(minUsia, ...rekapData.map(d => d.usia)); //menentukan usia minimum
            maxUsia = Math.max(maxUsia, ...rekapData.map(d => d.usia)); //menentukan usia maksimum
        }
        const chartLabels = Array.from({ length: maxUsia + 1 }, (_, i) => i); //membuat array untuk sumbu x.usia

        const balitaHeightData = [];
        rekapData.forEach(item => {
            balitaHeightData.push({ x: item.usia, y: item.tb }); //memformat  tinggi balita untuk chart js
        });


        const p3DataHeight = whoStandardsHeight.map(item => ({ x: item.usia, y: item['3rd'] })); //Memformat data persentil 3 WHO
        const p15DataHeight = whoStandardsHeight.map(item => ({ x: item.usia, y: item['15th'] }));
        const medianDataHeight = whoStandardsHeight.map(item => ({ x: item.usia, y: item['median'] }));
        const p85DataHeight = whoStandardsHeight.map(item => ({ x: item.usia, y: item['85th'] }));
        const p97DataHeight = whoStandardsHeight.map(item => ({ x: item.usia, y: item['97th'] }));

        //Membuat instance grafik Chart.js
        new Chart(ctxHeight, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Data Pengukuran {{ $balita->nama }}',
                        data: balitaHeightData,
                        borderColor: '#007bff',
                        backgroundColor: '#007bff',
                        pointRadius: 5,
                        pointBackgroundColor: '#007bff',
                        showLine: true,
                        tension: 0.2,
                        fill: false,
                        type: 'line',
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        //Label untuk garis standar WHO P3.
                        label: 'WHO P3 (Sangat Pendek)',
                        //Data persentil 3 WHO.
                        data: p3DataHeight,
                        //Warna garis merah.
                        borderColor: 'rgba(255, 99, 132, 0.7)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        // Garis putus-putus.
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        // Tidak menampilkan titik
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P15 (Pendek)',
                        data: p15DataHeight,
                        borderColor: 'rgba(255, 159, 64, 0.7)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO Median (Normal)',
                        data: medianDataHeight,
                        borderColor: 'rgba(75, 192, 192, 0.9)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P85 (Tinggi)',
                        data: p85DataHeight,
                        borderColor: 'rgba(54, 162, 235, 0.7)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P97 (Sangat Tinggi)',
                        data: p97DataHeight,
                        borderColor: 'rgba(153, 102, 255, 0.7)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'linear',
                        title: { display: true, text: 'Usia (bulan)' },
                        min: 0,
                        max: 60,
                        ticks: { stepSize: 6 }
                    },
                    y: {
                        title: { display: true, text: 'Tinggi Badan (cm)' },
                        beginAtZero: false,
                        min: Math.floor(Math.min(...Object.values(whoStandardsHeight).flatMap(o => [o['3rd'], o['97th']]), ...rekapData.map(d => d.tb)) * 0.9),
                        max: Math.ceil(Math.max(...Object.values(whoStandardsHeight).flatMap(o => [o['3rd'], o['97th']]), ...rekapData.map(d => d.tb)) * 1.1)
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                // Hanya tampilkan tooltip untuk dataset 'Data Pengukuran Balita'
                                if (context.dataset.label && context.dataset.label.startsWith('Data Pengukuran')) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' cm (Usia ' + context.parsed.x + ' bulan)';
                                }
                                return ''; // Jangan tampilkan label untuk dataset WHO standar
                            }
                        }
                    },
                    legend: { display: true, position: 'bottom' },
                    title: { display: true, text: 'Grafik Pertumbuhan Tinggi Badan per Usia (WHO)' }
                }
            }
        });

        // --- Bagian JavaScript untuk BB/U Dihapus ---
    });
</script>
@endpush