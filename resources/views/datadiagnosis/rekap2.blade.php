@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@endpush

@section('title', 'Rekap Data Diagnosis')
@section('judul', 'Rekap Data Diagnosis')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Rekap Data Diagnosis</h1>
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

            <div class="accordion" id="diagnosisAccordion">
                @foreach ($diagnoses->groupBy('balita.nama') as $namaBalita => $groupedDiagnoses)
                    @php $slug = Str::slug($namaBalita); $isFirst = $loop->first; @endphp

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $slug }}">
                            <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $slug }}">
                                {{ $namaBalita }}
                            </button>
                        </h2>
                        <div id="collapse{{ $slug }}" class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}">
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
                                        @foreach ($groupedDiagnoses as $diagnosis)
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
            @foreach ($diagnoses->groupBy('balita.nama') as $namaBalita => $groupedDiagnoses)
                const usia{{ $loop->index }} = {!! json_encode($groupedDiagnoses->pluck('usia')) !!};
                const bb{{ $loop->index }} = {!! json_encode($groupedDiagnoses->pluck('bb')) !!};
                const tb{{ $loop->index }} = {!! json_encode($groupedDiagnoses->pluck('tb')) !!};

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
