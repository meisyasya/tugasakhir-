@extends('layout.main')


@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .accordion-button {
            background-color: #eaf4ff;
            font-weight: 600;
        }
        .accordion-item {
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .accordion-body {
            background-color: #f9fcff;
        }
        table th, table td {
            vertical-align: middle !important;
            text-align: center;
        }
        canvas {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
@endpush


@section('title', 'Rekap Pertumbuhan Anak')
@section('judul', 'Rekap Pertumbuhan Anak')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Rekap Pertumbuhan Anak</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if ($errors->any())
                <div class="alert alert-danger my-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
                $groupedDiagnoses = $diagnoses->groupBy(function ($item) {
                    return $item->balita->nama ?? 'Tidak Diketahui';
                });
            @endphp

            <div class="accordion" id="diagnosisAccordion">
                @foreach ($groupedDiagnoses as $namaBalita => $grouped)
                    @php 
                        $slug = Str::slug($namaBalita); 
                        $isFirst = $loop->first; 
                    @endphp

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $slug }}">
                            <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $slug }}">
                                {{ $namaBalita }}
                            </button>
                        </h2>
                        <div id="collapse{{ $slug }}" class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}" data-bs-parent="#diagnosisAccordion">
                            <div class="accordion-body">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal Diagnosis</th>
                                            <th>Usia (bulan)</th>
                                            <th>BB (kg)</th>
                                            <th>TB (cm)</th>
                                            <th>IMT</th>
                                            <th>Status Gizi</th>
                                            <th>Hasil Diagnosis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grouped as $diagnosis)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($diagnosis->tanggal_diagnosis)->format('d-m-Y') }}</td>
                                                <td>{{ $diagnosis->usia }}</td>
                                                <td>{{ $diagnosis->bb }}</td>
                                                <td>{{ $diagnosis->tb }}</td>
                                                <td>{{ $diagnosis->imt }}</td>
                                                <td>{{ $diagnosis->status_gizi }}</td>
                                                <td>{{ $diagnosis->hasil_diagnosis }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <h6 class="mt-4">Grafik Berat Badan per Usia</h6>
                                <canvas id="chart-bb-{{ $slug }}" height="100"></canvas>

                                <h6 class="mt-4">Grafik Tinggi Badan per Usia</h6>
                                <canvas id="chart-tb-{{ $slug }}" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($groupedDiagnoses as $namaBalita => $grouped)
                const usia{{ $loop->index }} = {!! json_encode($grouped->pluck('usia')) !!};
                const bb{{ $loop->index }} = {!! json_encode($grouped->pluck('bb')) !!};
                const tb{{ $loop->index }} = {!! json_encode($grouped->pluck('tb')) !!};

                // Berat Badan Chart
                new Chart(document.getElementById('chart-bb-{{ Str::slug($namaBalita) }}').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: usia{{ $loop->index }},
                        datasets: [{
                            label: 'Berat Badan (kg)',
                            data: bb{{ $loop->index }},
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.3,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: { display: true, text: 'Usia (bulan)' }
                            },
                            y: {
                                title: { display: true, text: 'Berat Badan (kg)' },
                                min: 0
                            }
                        }
                    }
                });

                // Tinggi Badan Chart
                new Chart(document.getElementById('chart-tb-{{ Str::slug($namaBalita) }}').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: usia{{ $loop->index }},
                        datasets: [{
                            label: 'Tinggi Badan (cm)',
                            data: tb{{ $loop->index }},
                            borderColor: 'rgb(255, 99, 132)',
                            tension: 0.3,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: { display: true, text: 'Usia (bulan)' }
                            },
                            y: {
                                title: { display: true, text: 'Tinggi Badan (cm)' },
                                min: 40
                            }
                        }
                    }
                });
            @endforeach
        });
    </script>
@endpush
