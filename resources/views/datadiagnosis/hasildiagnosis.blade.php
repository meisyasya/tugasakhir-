@extends('layout.main')

@section('title', 'Diagnosis Stunting')
@section('judul', 'Diagnosis Stunting')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hasil Diagnosis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Hasil Diagnosis</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-notes-medical"></i> Data Diagnosis</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr><th>NIK</th><td>{{ optional($balita)->nik }}</td></tr>
                                <tr><th>Nama Balita</th><td>{{ optional($balita)->nama }}</td></tr>
                                <tr><th>Ibu</th><td>{{ optional($balita)->nama_ibu }}</td></tr>
                                <tr><th>Jenis Kelamin</th><td>{{ optional($balita)->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                                <tr><th>Usia</th><td>{{ optional($diagnosis)->usia }} bulan</td></tr>
                                <tr><th>Berat Badan</th><td>{{ optional($diagnosis)->bb }} kg</td></tr>
                                <tr><th>Tinggi Badan</th><td>{{ optional($diagnosis)->tb }} cm</td></tr>
                                <tr><th>Lingkar Kepala</th><td>{{ optional($diagnosis)->lingkar_kepala }} cm</td></tr>
                                <tr><th>IMT</th><td>{{ optional($diagnosis)->imt }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow mt-3">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Analisis Pertumbuhan</h3>
                        </div>
                        <div class="card-body text-center">

                            {{-- ============================================= --}}
                            {{-- BAGIAN BAR STUNTING (Tinggi Badan per Usia) --}}
                            {{-- ============================================= --}}
                            <h5 class="text-bold mt-3">Status Stunting (Tinggi Badan / Usia)</h5>
@php
    // Ambil status stunting dari hasil diagnosis. 
    $statusStunting = optional($diagnosis)->hasil_diagnosis;
    $tinggiBadan = optional($diagnosis)->tb;
    // Inisialisasi variabel untuk kelas CSS yang akan menentukan warna teks status.
    $stuntingClass = '';
    if ($statusStunting == 'Stunting Berat') {
        $stuntingClass = 'text-danger'; // Merah untuk indikasi berat
    } elseif ($statusStunting == 'Stunting Ringan') {
        $stuntingClass = 'text-warning'; //kuning
    } else {
        $stuntingClass = 'text-success';//hijau
    }
@endphp

{{-- Menampilkan status stunting dengan warna yang sesuai --}}
<h4 class="{{ $stuntingClass }}">
    {{ $statusStunting }}
</h4>
{{-- tinggi badan balita --}}
<p>Tinggi Badan: {{ $tinggiBadan }} cm</p>

@if($standarTB)
    @php
        // mengambil batas minimun
        $overallMinTb = $standarTB['overall_min'] ?? 0;
        // mengambil batas maksimum
        $overallMaxTb = $standarTB['overall_max'] ?? 100;
        // hitung rentang
        $rangeTbTotal = $overallMaxTb - $overallMinTb;

        //mengambil range (dari - sampai)
        $tb_red_segment = $standarTB['ranges']['red'] ?? [0, 0];
        $tb_yellow_segment = $standarTB['ranges']['yellow'] ?? [0, 0];
        $tb_green_segment = $standarTB['ranges']['green'] ?? [0, 0];

        // Mendestrukturisasi array segmen untuk mendapatkan nilai 'from' dan 'to' secara terpisah.
        $tb_red_from = $tb_red_segment[0];
        $tb_red_to = $tb_red_segment[1];

        $tb_yellow_from = $tb_yellow_segment[0];
        $tb_yellow_to = $tb_yellow_segment[1];

        $tb_green_from = $tb_green_segment[0];
        $tb_green_to = $tb_green_segment[1];

        // Tinggi badan aktual anak penentu bar
        $tinggi_badan_actual = $diagnosis->tb ?? 0;

        // Hitung posisi indikator (tetap menggunakan persentase dari keseluruhan rentang)
        $positionTb = 0; // Inisialisasi posisi awal sebagai 0 (paling kiri)
        if ($rangeTbTotal > 0) {
            $positionTb = (($tinggi_badan_actual - $overallMinTb) / $rangeTbTotal) * 100;
            $positionTb = max(0, min(100, $positionTb));
        }
    @endphp

    <div class="custom-progress-bar-container">
        
        <div class="progress-segment red" data-range-from="{{ $tb_red_from }}" data-range-to="{{ $tb_red_to }}">
            <span>{{ number_format($tb_red_from, 1) }} - {{ number_format($tb_red_to, 1) }} cm</span>
        </div>
        
        <div class="progress-segment yellow" data-range-from="{{ $tb_yellow_from }}" data-range-to="{{ $tb_yellow_to }}">
            <span>{{ number_format($tb_yellow_from, 1) }} - {{ number_format($tb_yellow_to, 1) }} cm</span>
        </div>
        
        <div class="progress-segment green" data-range-from="{{ $tb_green_from }}" data-range-to="{{ $tb_green_to }}">
            <span>&ge; {{ number_format($tb_green_from, 1) }} cm</span>
        </div>

        <div class="progress-indicator" style="left: {{ number_format($positionTb, 4) }}%;">
            <i class="fas fa-child"></i>
        </div>
    </div>
    <small class="text-muted d-block mt-2">WHO</small>
@else
    <div class="alert alert-info mt-3">Data standar Tinggi Badan / Usia tidak tersedia untuk usia ini.</div>
@endif



                            <hr class="my-4">

                            {{-- =================================== --}}
                            {{-- BAGIAN BAR GIZI (IMT per Usia) - Standar WHO (4 Kategori) --}}
                            {{-- =================================== --}}
                            <h5 class="text-bold mt-4">Status Gizi (IMT / Usia)</h5>
                            @php
                                $statusGizi = optional($diagnosis)->status_gizi;
                                $imt_value = optional($diagnosis)->imt; // Mengambil nilai IMT mentah dari diagnosis
                                $imt = is_numeric($imt_value) ? round($imt_value, 1) : 0; // Pembulatan untuk tampilan IMT

                                $giziClass = match($statusGizi) {
                                    'Sangat Kurus', 'Obesitas' => 'text-danger',
                                    'Kurus', 'Berisiko Gizi Lebih', 'Gizi Lebih' => 'text-warning',
                                    default => 'text-success', // Normal
                                };
                            @endphp

                            <h4 class="{{ $giziClass }}">
                                {{ $statusGizi }}
                            </h4>
                            <p>Indeks Massa Tubuh (IMT): {{ $imt }}</p>

                            @if($standarIMT)
    @php
        $imt_for_calculation = is_numeric($imt_value) ? (float) $imt_value : 0;

        $overallMinImt = $standarIMT['overall_min'] ?? 0;
        $overallMaxImt = $standarIMT['overall_max'] ?? 30; // Pastikan ini sesuai dengan standar WHO Anda
        $rangeImtTotal = $overallMaxImt - $overallMinImt;

        // Ambil batas rentang dari $standarIMT['ranges']. Sesuaikan nama kuncinya!
        // Red (Sangat Kurus)
        $imt_red_sangat_kurus_range = $standarIMT['ranges']['red_sangat_kurus'] ?? [0, 0];
        $imt_red_from = $imt_red_sangat_kurus_range[0];
        $imt_red_to = $imt_red_sangat_kurus_range[1];

        // Yellow (Kurus)
        $imt_yellow_kurus_range = $standarIMT['ranges']['yellow_kurus'] ?? [0, 0];
        $imt_yellow_from = $imt_yellow_kurus_range[0];
        $imt_yellow_to = $imt_yellow_kurus_range[1];

        // Green (Normal)
        $imt_green_normal_range = $standarIMT['ranges']['green_normal'] ?? [0, 0];
        $imt_green_from = $imt_green_normal_range[0];
        $imt_green_to = $imt_green_normal_range[1];

        // Blue (Risiko Gizi Lebih)
        $imt_blue_risiko_range = $standarIMT['ranges']['blue_risiko'] ?? [0, 0];
        $imt_blue_from = $imt_blue_risiko_range[0];
        $imt_blue_to = $imt_blue_risiko_range[1];

        // Dark Blue (Gizi Lebih) - Jika ingin ditampilkan sebagai segmen terpisah
        $imt_dark_blue_gizi_lebih_range = $standarIMT['ranges']['dark_blue_gizi_lebih'] ?? [0, 0];
        $imt_dark_blue_gizi_lebih_from = $imt_dark_blue_gizi_lebih_range[0];
        $imt_dark_blue_gizi_lebih_to = $imt_dark_blue_gizi_lebih_range[1];

        // Red (Obesitas) - Jika ingin ditampilkan sebagai segmen terpisah (hati-hati dengan duplikasi 'red')
        $imt_red_obesitas_range = $standarIMT['ranges']['red_obesitas'] ?? [0, 0];
        $imt_red_obesitas_from = $imt_red_obesitas_range[0];
        $imt_red_obesitas_to = $imt_red_obesitas_range[1];

        // --- Perhitungan Lebar Segmen ---
        // Penting: Anda memiliki 6 kategori, tetapi progress bar Anda hanya 4.
        // Anda perlu memutuskan bagaimana menggabungkan kategori-kategori ini menjadi 4 segmen.
        // Contoh:
        // Segmen Merah (Sangat Kurus)
        $widthImtSegRed = ($rangeImtTotal > 0) ? (($imt_red_to - $imt_red_from) / $rangeImtTotal) * 100 : 0;

        // Segmen Kuning (Kurus)
        $widthImtSegYellow = ($rangeImtTotal > 0) ? (($imt_yellow_to - $imt_yellow_from) / $rangeImtTotal) * 100 : 0;

        // Segmen Hijau (Normal + Risiko Gizi Lebih)
        // Anda perlu menggabungkan Normal dan Risiko Gizi Lebih jika ingin tetap 4 segmen
        $combined_green_from = $imt_green_from; // Dimulai dari Normal
        $combined_green_to = $imt_blue_to; // Berakhir di batas atas Risiko Gizi Lebih
        $widthImtSegGreen = ($rangeImtTotal > 0) ? (($combined_green_to - $combined_green_from) / $rangeImtTotal) * 100 : 0;


        // Segmen Biru (Gizi Lebih + Obesitas)
        // Anda perlu menggabungkan Gizi Lebih dan Obesitas
        $combined_blue_from = $imt_dark_blue_gizi_lebih_from; // Dimulai dari Gizi Lebih
        $combined_blue_to = $imt_red_obesitas_to; // Berakhir di batas atas Obesitas
        $widthImtSegBlue = ($rangeImtTotal > 0) ? (($combined_blue_to - $combined_blue_from) / $rangeImtTotal) * 100 : 0;


        // Normalisasi total lebar untuk memastikan 100%.
        $totalWidthImtCalculated = $widthImtSegRed + $widthImtSegYellow + $widthImtSegGreen + $widthImtSegBlue;
        if ($totalWidthImtCalculated > 0) {
            $widthImtSegRed = ($widthImtSegRed / $totalWidthImtCalculated) * 100;
            $widthImtSegYellow = ($widthImtSegYellow / $totalWidthImtCalculated) * 100;
            $widthImtSegGreen = ($widthImtSegGreen / $totalWidthImtCalculated) * 100;
            $widthImtSegBlue = ($widthImtSegBlue / $totalWidthImtCalculated) * 100;
        }

        // Hitung posisi indikator (ini harusnya tidak berubah)
        $positionImt = 0;
        if ($rangeImtTotal > 0) {
            $positionImt = (($imt_for_calculation - $overallMinImt) / $rangeImtTotal) * 100;
            $positionImt = max(0, min(100, $positionImt));
        }
    @endphp

    <div class="custom-progress-bar-container">
        <div class="progress-segment imt-red" style="width: {{ number_format($widthImtSegRed, 4) }}%;">
            <span>&lt; {{ number_format($imt_red_to, 1) }}</span>
        </div>
        <div class="progress-segment imt-yellow" style="width: {{ number_format($widthImtSegYellow, 4) }}%;">
            <span>{{ number_format($imt_yellow_from, 1) }} - &lt; {{ number_format($imt_yellow_to, 1) }}</span>
        </div>
        <div class="progress-segment imt-green" style="width: {{ number_format($widthImtSegGreen, 4) }}%;">
            {{-- Label untuk segmen hijau yang digabungkan --}}
            <span>{{ number_format($combined_green_from, 1) }} - {{ number_format($combined_green_to, 1) }}</span>
        </div>
        <div class="progress-segment imt-blue-who" style="width: {{ number_format($widthImtSegBlue, 4) }}%;">
            {{-- Label untuk segmen biru yang digabungkan --}}
            <span>&ge; {{ number_format($combined_blue_from, 1) }}</span>
        </div>
        <div class="progress-indicator" style="left: {{ number_format($positionImt, 4) }}%;">
            <i class="fas fa-child"></i>
        </div>
    </div>
    <small class="text-muted d-block mt-2">WHO</small>
@else
    <div class="alert alert-info mt-3">Data standar IMT/U tidak tersedia untuk usia ini.</div>
@endif
                        </div>
                        
                    {{-- Bagian tombol WhatsApp --}}
                    @if(
                        optional($diagnosis)->hasil_diagnosis &&
                        optional($balita->user)->phone &&
                        preg_match('/^0[0-9]{9,13}$/', $balita->user->phone)
                    )
                        @php
                            $btnClass = match(optional($diagnosis)->hasil_diagnosis) {
                                'Stunting Berat' => 'btn-danger',
                                'Stunting Ringan' => 'btn-warning',
                                default => 'btn-success',
                            };

                            $btnLabel = match(optional($diagnosis)->hasil_diagnosis) {
                                'Stunting Berat' => 'Kirim Pesan WhatsApp (Berat)',
                                'Stunting Ringan' => 'Kirim Pesan WhatsApp (Ringan)',
                                default => 'Kirim Pesan WhatsApp (Normal)',
                            };
                        @endphp

                        <div class="text-center mt-3">
                            <form action="{{ route('admin.diagnosis.kirimWA', ['diagnosisId' => $diagnosis->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="hasil_diagnosis" value="{{ $diagnosis->hasil_diagnosis }}">
                                <input type="hidden" name="tb" value="{{ $diagnosis->tb }}">
                                <input type="hidden" name="nama" value="{{ $balita->nama }}">
                                <input type="hidden" name="lingkar_kepala_balita" value="{{ optional($diagnosis)->lingkar_kepala }}">

                                <button type="submit" class="btn {{ $btnClass }}">
                                    <i class="fab fa-whatsapp"></i> {{ $btnLabel }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-warning text-center mt-3">
                            <i class="fas fa-exclamation-triangle"></i> Nomor WhatsApp belum tersedia atau tidak valid.
                        </div>
                    @endif

                    <div class="col-12">
                        @can('post-admin')
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.DataDiagnosisIndex') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        @endcan

                        @can('post-kader')
                        <div class="text-center mt-3">
                            <a href="{{ route('kader.DataDiagnosisIndex') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('css')
<style>
    .custom-progress-bar-container {
        position: relative;
        display: flex; /* Menggunakan flexbox untuk tata letak segmen */
        width: 100%;
        height: 30px; /* Tinggi bar */
        margin-top: 15px;
        border-radius: 5px;
        overflow: hidden;
        background-color: #e9ecef;
        border: 1px solid #ccc;
    }

    .progress-segment {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        text-align: center;
        height: 100%;
        box-sizing: border-box;
        padding: 0 3px; /* Jaga padding agar teks tidak terlalu mepet tepi */
        flex-shrink: 0; /* Mencegah segmen menyusut di bawah kontennya */
    }

    /* Stunting Bar Colors (Tinggi Badan / Usia) */
    .progress-segment.red {
        background-color: #dc3545; /* danger */
        flex-grow: 0; /* Tidak akan tumbuh secara fleksibel */
        /* min-width ini disesuaikan agar teks '0 - 68.5 cm' muat */
        min-width: 100px; /* Coba nilai fix px, lalu sesuaikan */
    }
    .progress-segment.yellow {
        background-color: #ffc107; /* warning */
        flex-grow: 0; /* Tidak akan tumbuh secara fleksibel */
        /* min-width ini disesuaikan agar teks '68.6 - 70.9 cm' muat */
        min-width: 100px; /* Coba nilai fix px, lalu sesuaikan */
    }
    .progress-segment.green {
        background-color: #28a745; /* success */
        flex-grow: 1; /* PENTING: Segmen hijau akan mengisi SISA ruang */
        /* tidak perlu min-width karena dia akan mengembang */
    }

    /* IMT Bar Colors (IMT / Usia) - Standar WHO (4 Kategori) */
    .progress-segment.imt-red {
        background-color: #dc3545; /* Sangat Kurus */
        flex-grow: 0;
        min-width: 60px; /* Sesuaikan untuk teks "< 13.4" */
    }
    .progress-segment.imt-yellow {
        background-color: #ffc107; /* Kurus */
        flex-grow: 0;
        min-width: 80px; /* Sesuaikan untuk teks "13.4 - < 14.x" */
    }
    .progress-segment.imt-green {
        background-color: #28a745; /* Normal */
        flex-grow: 1; /* Akan mengisi sisa ruang */
    }
    .progress-segment.imt-blue-who {
        background-color: #007bff; /* Risiko Gizi Lebih/Gizi Lebih/Obesitas */
        flex-grow: 1; /* Akan mengisi sisa ruang */
    }

    /* Progress Indicator (Child Icon) */
    .progress-indicator {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.8em;
        color: #000;
        z-index: 10;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    .progress-indicator i {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        padding: 2px;
        box-shadow: 0 0 5px rgba(0,0,0,0.5);
    }

    /* Small text inside segments */
    .custom-progress-bar-container .progress-segment span {
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        font-size: 0.6em; /* Sedikit lebih kecil agar lebih muat, tapi tetap terbaca */
        line-height: 1;
        overflow: hidden;
        text-overflow: ellipsis; /* Tambahkan elipsis jika teks terpotong */
        white-space: nowrap; /* Teks tetap dalam satu baris */
        flex-shrink: 1; /* Biarkan teks menyusut jika tidak muat */
        min-width: 0; /* default untuk span */
    }
</style>
@endpush

@endsection