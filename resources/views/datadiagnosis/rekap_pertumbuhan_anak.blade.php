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
        /* Style untuk tabel WHO */
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
                        // Urutkan data balita berdasarkan usia untuk tabel yang benar
                        $balitaDataSorted = $grouped->sortBy('usia')->values();

                        // Ambil jenis kelamin balita pertama dari grup, asumsi semua dalam grup sama
                        $jenisKelaminBalita = $grouped->first()->balita->jenis_kelamin ?? 'Perempuan'; // Default ke Perempuan
                        $jenisKelaminUntukTabel = ($jenisKelaminBalita == 'Laki-laki' ? 'Laki-laki' : 'Perempuan');
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
                                <h6 class="mb-3">Data Pengukuran Anak</h6>
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal Diagnosis</th>
                                            <th>Usia (bulan)</th>
                                            <th>BB (kg)</th> {{-- Kolom BB tetap ada di sini --}}
                                            <th>TB (cm)</th>
                                            <th>IMT</th>
                                            <th>Lingkar Kepala</th>
                                            <th>Status Gizi (IMT/U)</th>
                                            <th>Hasil Diagnosis (Stunting)</th>
                                            <th>Rekomendasi Kesehatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Gunakan $balitaDataSorted agar tabel juga terurut --}}
                                        @foreach ($balitaDataSorted as $diagnosis)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($diagnosis->tanggal_diagnosis)->format('d-m-Y') }}</td>
                                                <td>{{ $diagnosis->usia }}</td>
                                                <td>{{ $diagnosis->bb }}</td> {{-- Data Berat Badan tetap ditampilkan --}}
                                                <td>{{ $diagnosis->tb }}</td>
                                                <td>{{ number_format($diagnosis->imt, 2) }}</td>
                                                <td>{{ $diagnosis->lingkar_kepala }}</td>
                                                <td>{{ $diagnosis->status_gizi }}</td>
                                                <td>{{ $diagnosis->hasil_diagnosis }}</td>
                                                <td>
                                                    @php
                                                        $statusStunting = $diagnosis->hasil_diagnosis;
                                                        $rekomendasiTeks = $rekomendasis[$statusStunting]->rekomendasi ?? 'Rekomendasi tidak ditemukan.';
                                                    @endphp
                                                    <span style="text-align: left; display: block;">{!! $rekomendasiTeks !!}</span>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 text-end">
                                    @can('post-admin')
                                    <a href="{{ route('admin.rekap.tb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Stunting</a>
                                    <a href="{{ route('admin.rekap.bb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Gizi</a>
                                    @endcan
                                    @can('post-bidan')
                                    <a href="{{ route('bidan.rekap.tb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Stunting</a>
                                    <a href="{{ route('bidan.rekap.bb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Gizi</a>
                                    @endcan
                                    @can('post-ortu')
                                    <a href="{{ route('ortu.rekap.tb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Stunting</a>
                                    <a href="{{ route('ortu.rekap.bb_usia', $diagnosis->balita_id) }}" class="btn btn-primary">Grafik Gizi</a>
                                    @endcan

                                </div>

                                {{-- ================================================================= --}}
                                {{-- TABEL DATA WHO UNTUK TINGGI BADAN (HEIGHT-FOR-AGE) --}}
                                {{-- ================================================================= --}}
                              



                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
</div>
@endsection

{{-- Bagian @push('js') dihapus sepenuhnya karena tidak ada lagi grafik --}}
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}} {{-- Chart.js tidak diperlukan jika tidak ada grafik --}}
@endpush