
@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* ... CSS yang sudah ada ... */
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
            background-color: #d1ecf1 !important;
            font-weight: bold;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .chart-container {
            position: relative;
            height: 400px;
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

@section('title', 'Grafik Gizi (BB/U) ' . $balita->nama)
@section('judul', 'Grafik Gizi (BB/U) ' . $balita->nama)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            @can('post-admin')
            <div class="page-header">
                <h1 class="m-0">Grafik Berat Badan per Usia (BB/U) {{ $balita->nama }}</h1>
                <a href="{{ route('admin.pertumbuhananak') }}" class="btn btn-secondary">Kembali ke Rekap Umum</a>
            </div>
            @endcan
            @can('post-bidan')
            <div class="page-header">
                <h1 class="m-0">Grafik Berat Badan per Usia (BB/U) {{ $balita->nama }}</h1>
                <a href="{{ route('bidan.pertumbuhananak') }}" class="btn btn-secondary">Kembali ke Rekap Umum</a>
            </div>
            @endcan
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Bagian Grafik Berat Badan --}}
            <div class="chart-container">
                <canvas id="weightForAgeChart"></canvas>
            </div>

            <hr class="my-4">

            <h4>Data Rekap Berat Badan per Usia (BB/U)</h4>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Pengukuran</th>
                        <th>Usia (bulan)</th>
                        <th>BB (kg)</th>
                        <th>Status Gizi (BB/U)</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapData as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $data->usia }}</td>
                            <td>{{ $data->bb }}</td>
                            <td>{{ $data->calculated_status_gizi_bb_u ?? 'N/A' }}</td>
                            <td>{{ $data->calculated_diagnosis_description ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data pengukuran berat badan untuk balita ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <hr class="my-4">

            <h4>Standar Berat Badan per Usia (BB/U) WHO untuk {{ $balita->jenis_kelamin }}</h4>
            @if (!empty($selectedWhoStandardWeight))
                <table class="who-table">
                    <thead>
                        <tr>
                            <th>Usia (bulan)</th>
                            <th>P3 (Sangat Kurus)</th>
                            <th>P15 (Kurus)</th>
                            <th>P50 (Normal)</th>
                            <th>P85 (Gemuk)</th>
                            <th>P97 (Sangat Gemuk)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedWhoStandardWeight as $standard)
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
                <p>Data standar WHO Berat Badan per Usia untuk jenis kelamin {{ $balita->jenis_kelamin }} tidak ditemukan.</p>
            @endif

        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxWeight = document.getElementById('weightForAgeChart').getContext('2d');

        const rekapData = @json($rekapData);
        const whoStandardsWeight = @json($selectedWhoStandardWeight); // Pastikan ini sesuai dengan nama variabel yang dikirim dari controller

        let minUsia = 0;
        let maxUsia = 60;
        if (rekapData.length > 0) {
            minUsia = Math.min(minUsia, ...rekapData.map(d => d.usia));
            maxUsia = Math.max(maxUsia, ...rekapData.map(d => d.usia));
        }
        const chartLabels = Array.from({ length: maxUsia + 1 }, (_, i) => i);

        const balitaWeightData = [];
        rekapData.forEach(item => {
            balitaWeightData.push({ x: item.usia, y: item.bb });
        });

        const p3DataWeight = whoStandardsWeight.map(item => ({ x: item.usia, y: item['3rd'] }));
        const p15DataWeight = whoStandardsWeight.map(item => ({ x: item.usia, y: item['15th'] }));
        const medianDataWeight = whoStandardsWeight.map(item => ({ x: item.usia, y: item['median'] }));
        const p85DataWeight = whoStandardsWeight.map(item => ({ x: item.usia, y: item['85th'] }));
        const p97DataWeight = whoStandardsWeight.map(item => ({ x: item.usia, y: item['97th'] }));

        new Chart(ctxWeight, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Data Pengukuran {{ $balita->nama }}',
                        data: balitaWeightData,
                        borderColor: '#28a745',
                        backgroundColor: '#28a745',
                        pointRadius: 5,
                        pointBackgroundColor: '#28a745',
                        showLine: true,
                        tension: 0.2,
                        fill: false,
                        type: 'line',
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P3 (Sangat Kurus)',
                        data: p3DataWeight,
                        borderColor: 'rgba(255, 99, 132, 0.7)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderDash: [5, 5],
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P15 (Kurus)',
                        data: p15DataWeight,
                        borderColor: 'rgba(255, 159, 64, 0.7)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO Median (Normal)',
                        data: medianDataWeight,
                        borderColor: 'rgba(75, 192, 192, 0.9)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P85 (Gemuk)',
                        data: p85DataWeight,
                        borderColor: 'rgba(54, 162, 235, 0.7)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                    },
                    {
                        label: 'WHO P97 (Sangat Gemuk)',
                        data: p97DataWeight,
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
                        title: { display: true, text: 'Berat Badan (kg)' },
                        beginAtZero: false,
                        min: Math.floor(Math.min(...Object.values(whoStandardsWeight).flatMap(o => [o['3rd'], o['97th']]), ...rekapData.map(d => d.bb)) * 0.9),
                        max: Math.ceil(Math.max(...Object.values(whoStandardsWeight).flatMap(o => [o['3rd'], o['97th']]), ...rekapData.map(d => d.bb)) * 1.1)
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + ' kg (Usia ' + context.parsed.x + ' bulan)';
                                }
                                return label;
                            }
                        }
                    },
                    legend: { display: true, position: 'bottom' },
                    title: { display: true, text: 'Grafik Pertumbuhan Berat Badan per Usia (WHO)' }
                }
            }
        });
    });
</script>
@endpush