@extends('layout.main')

@section('title', 'Diagnosis Stunting')
@section('judul', 'Diagnosis Stunting')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
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

    <!-- Main Content -->
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
                                <tr><th>Jenis Kelamin</th><td>{{ optional($balita)->jenis_kelamin }}</td></tr>
                                <tr><th>Usia</th><td>{{ optional($diagnosis)->usia }} bulan</td></tr>
                                <tr><th>Berat Badan</th><td>{{ optional($diagnosis)->bb }} kg</td></tr>
                                <tr><th>Tinggi Badan</th><td>{{ optional($diagnosis)->tb }} cm</td></tr>
                                <tr><th>IMT</th><td>{{ optional($diagnosis)->imt }}</td></tr>
                            </table>                            
                        </div>
                    </div>

                    <div class="card shadow mt-3">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title"><i class="fas fa-child"></i> Hasil Diagnosis</h3>
                        </div>
                        <div class="card-body text-center">
                            <!-- Status Stunting -->
                            <h4 class="{{ optional($diagnosis)->hasil_diagnosis == 'Stunting Berat' ? 'text-danger' : (optional($diagnosis)->hasil_diagnosis == 'Stunting Ringan' ? 'text-warning' : 'text-success') }}">
                                {{ optional($diagnosis)->hasil_diagnosis }}
                            </h4>
                            <p>Tinggi Badan: {{ optional($diagnosis)->tb }} cm</p>
                    
                            <!-- Progress Bar for Stunting -->
                            <div class="progress">
                                <div class="progress-bar {{ optional($diagnosis)->hasil_diagnosis == 'Stunting Berat' ? 'bg-danger' : (optional($diagnosis)->hasil_diagnosis == 'Stunting Ringan' ? 'bg-warning' : 'bg-success') }}" style="width: 100%">
                                    {{ optional($diagnosis)->hasil_diagnosis }}
                                </div>
                            </div>
                    
                            <hr>
                    
                            <!-- Status Gizi -->
                            <h4 class="{{ optional($diagnosis)->status_gizi == 'Gizi Buruk' ? 'text-danger' : (optional($diagnosis)->status_gizi == 'Gizi Kurang' ? 'text-warning' : 'text-success') }}">
                                {{ optional($diagnosis)->status_gizi }}
                            </h4>
                            <p>Indeks Massa Tubuh (IMT): {{ optional($diagnosis)->imt }}</p>
                    
                            <!-- Progress Bar for IMT (Gizi) -->
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: 15%">Gizi Buruk (-3 SD)</div>
                                <div class="progress-bar bg-warning" style="width: 15%">Gizi Kurang (-2 SD)</div>
                                <div class="progress-bar bg-success" style="width: 30%">Gizi Normal (-2 to +1 SD)</div>
                                <div class="progress-bar bg-info" style="width: 20%">Berisiko Gizi Lebih (+1 to +2 SD)</div>
                                <div class="progress-bar bg-primary" style="width: 20%">Gizi Lebih (+2 to +3 SD)</div>
                                <div class="progress-bar bg-dark" style="width: 10%">Obesitas (+3 SD)</div>
                            </div>
                        </div>
                    </div>

                   <!-- Tombol Kirim WhatsApp -->
<!-- Tombol Kirim WhatsApp berdasarkan hasil diagnosis -->
@if(optional($diagnosis)->hasil_diagnosis && optional($balita->user)->phone)
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
        <form action="{{ route('admin.diagnosis.kirimWA', $balita->id) }}" method="POST">
            @csrf
            <input type="hidden" name="hasil_diagnosis" value="{{ $diagnosis->hasil_diagnosis }}">
            <input type="hidden" name="tb" value="{{ $diagnosis->tb }}">
            <input type="hidden" name="nama" value="{{ $balita->nama }}">
            <button type="submit" class="btn {{ $btnClass }}">
                <i class="fab fa-whatsapp"></i> {{ $btnLabel }}
            </button>
        </form>
    </div>
@else
    <div class="alert alert-warning text-center mt-3">
        <i class="fas fa-exclamation-triangle"></i> Nomor WhatsApp belum tersedia.
    </div>
@endif


                    <!-- Tombol Kembali -->
                    <div class="col-12">
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.DataDiagnosisIndex') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
