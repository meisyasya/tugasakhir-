@extends('layout.main')

@section('title')
    Dashboard
@endsection

@section('judul')
    Dashboard
@endsection

@push('css') {{-- Pindahkan style ke push('css') agar konsisten dengan cara Laravel Mix/Vite --}}
<style>
/* Styling umum untuk small-box */
.small-box {
    border-radius: 10px; /* Membuat sudut lebih bulat */
    transition: all 0.3s ease; /* Efek transisi pada hover */
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan lembut pada kotak */
    position: relative;
    color: white; /* Pastikan teks di dalam kotak putih */
}

/* Hover effect untuk memperbesar dan memberikan bayangan */
.small-box:hover {
    transform: translateY(-5px); /* Mengangkat kotak sedikit */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar */
}

/* Styling ikon di dalam small-box */
.small-box .icon {
    font-size: 40px;
    opacity: 0.8;
    transition: opacity 0.3s ease; /* Transisi halus pada opacity */
}

/* Hover effect pada ikon */
.small-box:hover .icon {
    opacity: 1; /* Mengubah opacity saat hover untuk memperjelas ikon */
}

/* Responsivitas untuk perangkat kecil */
@media (max-width: 768px) {
    .small-box {
        font-size: 14px; /* Menurunkan ukuran font di perangkat kecil */
        padding: 15px;
    }

    .small-box .inner h3 {
        font-size: 18px; /* Ukuran font h3 lebih kecil */
    }

    .small-box .inner p {
        font-size: 14px; /* Ukuran font p lebih kecil */
    }
}

/* Styling untuk container grafik */
.chart-container {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 30px; /* Jarak dari card di atasnya */
}
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- Anda bisa menambahkan breadcrumb di sini jika diperlukan --}}
                    </ol>
                </div></div></div></div>

   
    @cannot('post-ortu')
    <section class="content">
        <div class="container-fluid">
            {{-- Card section --}}
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_user }}</h3> {{-- Menggunakan data dari controller: $total_user --}}
                            <p>Total Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_balita }}</h3> {{-- Menggunakan data dari controller: $total_balita --}}
                            <p>Total Balita</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-child"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_stunting }}</h3> {{-- Menggunakan data dari controller: $total_stunting --}}
                            <p>Jumlah Anak Stunting</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End card section --}}

            {{-- Chart Section Admin/Kader --}}
            <div class="row">
                <div class="col-12">
                    <div class="card chart-container">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Data Balita dan Stunting Per Bulan</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyDataChart" style="height:300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Chart Section Admin/Kader --}}

        </div>
    </section>
    @endcannot


    {{-- Bagian Dashboard untuk Orang Tua --}}
    @can('post-ortu') 
    <section class="content">
        <div class="container-fluid">
            {{-- Card section --}}
            <div class="row">
                {{-- Kartu 1: Total Balita Anda --}}
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                            <h3>{{ $totalBalitaIbu }}</h3>
                            <p>Total Balita Anda</p>
                            <p class="text-white-75" style="font-size: 0.9em;">Ibu: {{ $namaIbu }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-baby"></i>
                        </div>
                        <a href="{{ route('ortu.DataAnakIndex') }}" class="small-box-footer">
                            Lihat Daftar Balita Saya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Kartu 2: Jadwal Posyandu Terdekat --}}
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box bg-gradient-primary">
                        <div class="inner">
                            <h3>Posyandu Melati 5</h3>
                            <p>Pada: 7 Juli 2025</p>
                            <p>Lokasi: Rumah Ibu Sukardi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <a href="" class="small-box-footer">
                            Datang Rutin ke Posyandu yaa</i>
                        </a>
                    </div>
                </div>
            </div>
            {{-- End card section --}}

            {{-- Chart Section untuk Orang Tua --}}
            <div class="row">
                @if(isset($balitaPertama) && $balitaPertama) {{-- Tampilkan grafik hanya jika ada balita --}}
                <div class="col-12">
                    <div class="card chart-container">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Pertumbuhan Tinggi Badan per Usia (TB/U) untuk {{ $balitaPertama->nama }}</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="heightForAgeChartOrtu" style="height:400px"></canvas> {{-- ID unik --}}
                        </div>
                        <div class="card-footer text-center">
                            <p class="mb-0">
                                <span style="display:inline-block; width:15px; height:8px; background-color:#007bff; border-radius:2px; margin-right:5px;"></span> Data Pengukuran {{ $balitaPertama->nama }}
                                <span style="display:inline-block; width:15px; height:8px; background-color:rgba(255, 99, 132, 0.7); border-radius:2px; margin-left:15px; margin-right:5px;"></span> WHO P3 (Sangat Pendek)
                                <span style="display:inline-block; width:15px; height:8px; background-color:rgba(255, 159, 64, 0.7); border-radius:2px; margin-left:15px; margin-right:5px;"></span> WHO P15 (Pendek)
                                <span style="display:inline-block; width:15px; height:8px; background-color:rgba(75, 192, 192, 0.9); border-radius:2px; margin-left:15px; margin-right:5px;"></span> WHO Median (Normal)
                                <span style="display:inline-block; width:15px; height:8px; background-color:rgba(54, 162, 235, 0.7); border-radius:2px; margin-left:15px; margin-right:5px;"></span> WHO P85 (Tinggi)
                                <span style="display:inline-block; width:15px; height:8px; background-color:rgba(153, 102, 255, 0.7); border-radius:2px; margin-left:15px; margin-right:5px;"></span> WHO P97 (Sangat Tinggi)
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada data balita yang terdaftar untuk akun Anda. Silakan <a href="{{ route('ortu.DataAnakIndex') }}">tambahkan balita</a> untuk melihat grafik pertumbuhan.
                    </div>
                </div>
                @endif
            </div>
            {{-- End Chart Section --}}

        </div>
    </section>
    @endcan

</div>
@endsection

@push('js') {{-- Pindahkan script ke push('js') --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Grafik untuk Admin/Kader (monthlyDataChart) ---
        // Pastikan elemen canvas dengan ID 'monthlyDataChart' ada
        var monthlyDataChartElement = document.getElementById('monthlyDataChart');
        if (monthlyDataChartElement) {
            var ctx = monthlyDataChartElement.getContext('2d');

            var months = @json($months ?? []);
            var balitaCounts = @json($balitaCounts ?? []);
            var stuntingCounts = @json($stuntingCounts ?? []);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Balita',
                        data: balitaCounts,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true
                    }, {
                        label: 'Jumlah Kasus Stunting',
                        data: stuntingCounts,
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        },
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Data Balita dan Stunting Per Bulan'
                        }
                    }
                }
            });
        }


        // --- Grafik Tinggi Badan per Usia (TB/U) untuk Orang Tua (heightForAgeChartOrtu) ---
        // Pastikan elemen canvas dengan ID 'heightForAgeChartOrtu' ada
        const ctxHeightOrtu = document.getElementById('heightForAgeChartOrtu');
        if (ctxHeightOrtu) { // Hanya jalankan jika elemen canvas ada (yaitu, jika ada balita)
            const rekapDataOrtu = @json($rekapDataOrtu ?? []);
            const whoStandardsHeightOrtu = @json($selectedWhoStandardHeightOrtu ?? []);
            const balitaNamaOrtu = @json($balitaPertama->nama ?? 'Balita Anda'); // Ambil nama balita pertama

            let minUsia = 0;
            let maxUsia = 60; // Default WHO max age
            if (rekapDataOrtu.length > 0) {
                // Sesuaikan min/max usia berdasarkan data balita jika ada, tetapi tetap di rentang WHO
                minUsia = Math.min(minUsia, ...rekapDataOrtu.map(d => d.usia));
                maxUsia = Math.max(maxUsia, ...rekapDataOrtu.map(d => d.usia));
            }
            // Pastikan rentang usia mencakup 0-60 bulan jika standar WHO lengkap
            maxUsia = Math.max(maxUsia, 60);

            // Buat array label usia dari 0 hingga maxUsia
            const chartLabelsOrtu = Array.from({ length: maxUsia + 1 }, (_, i) => i);


            const balitaHeightDataOrtu = [];
            rekapDataOrtu.forEach(item => {
                balitaHeightDataOrtu.push({ x: item.usia, y: item.tb });
            });

            // Pastikan data standar WHO ada sebelum memetakannya
            const p3DataHeightOrtu = whoStandardsHeightOrtu.map(item => ({ x: item.usia, y: item['3rd'] }));
            const p15DataHeightOrtu = whoStandardsHeightOrtu.map(item => ({ x: item.usia, y: item['15th'] }));
            const medianDataHeightOrtu = whoStandardsHeightOrtu.map(item => ({ x: item.usia, y: item['median'] }));
            const p85DataHeightOrtu = whoStandardsHeightOrtu.map(item => ({ x: item.usia, y: item['85th'] }));
            const p97DataHeightOrtu = whoStandardsHeightOrtu.map(item => ({ x: item.usia, y: item['97th'] }));

            new Chart(ctxHeightOrtu, {
                type: 'line',
                data: {
                    labels: chartLabelsOrtu,
                    datasets: [
                        {
                            label: 'Data Pengukuran ' + balitaNamaOrtu,
                            data: balitaHeightDataOrtu,
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
                            label: 'WHO P3 (Sangat Pendek)',
                            data: p3DataHeightOrtu,
                            borderColor: 'rgba(255, 99, 132, 0.7)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0,
                            tension: 0.4,
                            parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                        },
                        {
                            label: 'WHO P15 (Pendek)',
                            data: p15DataHeightOrtu,
                            borderColor: 'rgba(255, 159, 64, 0.7)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            fill: false,
                            pointRadius: 0,
                            tension: 0.4,
                            parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                        },
                        {
                            label: 'WHO Median (Normal)',
                            data: medianDataHeightOrtu,
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
                            data: p85DataHeightOrtu,
                            borderColor: 'rgba(54, 162, 235, 0.7)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                            pointRadius: 0,
                            tension: 0.4,
                            parsing: { xAxisKey: 'x', yAxisKey: 'y' }
                        },
                        {
                            label: 'WHO P97 (Sangat Tinggi)',
                            data: p97DataHeightOrtu,
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
                            // Sesuaikan min/max Y axis berdasarkan data dan standar WHO
                            min: Math.floor(Math.min(...whoStandardsHeightOrtu.map(o => o['3rd']), ...balitaHeightDataOrtu.map(d => d.y)) * 0.9),
                            max: Math.ceil(Math.max(...whoStandardsHeightOrtu.map(o => o['97th']), ...balitaHeightDataOrtu.map(d => d.y)) * 1.1)
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
                                        label += context.parsed.y.toFixed(2) + ' cm (Usia ' + context.parsed.x + ' bulan)';
                                    }
                                    return label;
                                }
                            }
                        },
                        legend: { display: false }, // Legenda akan dibuat manual di card-footer
                        title: { display: true, text: 'Grafik Pertumbuhan Tinggi Badan per Usia (WHO)' }
                    }
                }
            });
        }
    });
</script>
@endpush