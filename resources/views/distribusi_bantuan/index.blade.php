@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        /* Mengatur flexbox untuk tabel informasi */
        .info-table .row {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 10px; /* Jarak antar baris */
        }

        /* Kolom label (Posyandu, Tanggal Lahir, dll) */
        .info-table .col-label {
            width: 150px; /* Setel lebar kolom label secara konsisten */
            text-align: left; /* Ratakan teks label ke kiri */
            padding-right: 10px; /* Jarak antar label dan titik dua */
            font-weight: bold; /* Tebalkan label */
        }

        /* Kolom titik dua */
        .info-table .col-colon {
            width: 20px; /* Lebarkan kolom titik dua sedikit */
            text-align: left; /* Ratakan titik dua ke kiri */
        }

        /* Kolom nilai (data) */
        .info-table .col {
            text-align: left; /* Ratakan teks nilai ke kiri */
        }

        /* Styling untuk card */
        .balita-card {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            margin-bottom: 20px;
            max-width: 350px; /* Lebarkan card agar sedikit lebih besar */
            margin-left: auto;
            margin-right: auto;
        }

        .balita-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        /* Foto Balita */
        .balita-photo {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #f8f9fa;
            margin: 15px auto;
            display: block;
        }

        /* Body dari card */
        .card-body {
            padding: 15px;
            text-align: center;
        }

        /* Judul card */
        .card-title {
            font-size: 1.5rem;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Button */
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            padding: 10px 25px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
@endpush

@section('title', 'Distribusi Bantuan')
@section('judul', 'Distribusi Bantuan')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-size: 2rem; color: #007bff;">Distribusi Bantuan</h1>
                    <p class="lead text-muted">Daftar Balita yang menerima bantuan dengan status stunting berat atau ringan.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger my-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="col-12">
                        <div class="alert alert-success my-3">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @foreach ($stuntingData as $index => $data)
    <div class="col-md-3">
        <div class="card balita-card">
            <img src="{{ asset($data->balita->img) }}" alt="Foto Balita" class="balita-photo">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $data->balita->nama }}</h5>
                <div class="info-table d-inline-block text-start w-100">
                    <div class="row">
                        <div class="col-label">Posyandu</div>
                        <div class="col-colon">:</div>
                        <div class="col">{{ $data->balita->posyandu }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-label">Tanggal Lahir</div>
                        <div class="col-colon">:</div>
                        <div class="col">{{ \Carbon\Carbon::parse($data->balita->tanggal_lahir)->format('d M Y') }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-label">Nama Ibu</div>
                        <div class="col-colon">:</div>
                        <div class="col">{{ $data->balita->nama_ibu }}</div>
                    </div>

                    <!-- New row for Tanggal Diagnosis -->
                    <div class="row">
                        <div class="col-label">Tanggal Diagnosis</div>
                        <div class="col-colon">:</div>
                        <div class="col">
                            @if($data->tanggal)
                                {{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    
                </div>
                @can('post-admin')
                <a href="{{ route('admin.DistribusiBantuanShow', $data->id) }}" class="btn btn-custom">Lihat Detail</a>
                @endcan
                @can('post-kader')
                <a href="{{ route('kader.DistribusiBantuanShow', $data->id) }}" class="btn btn-custom">Lihat Detail</a>
                @endcan
                @can('post-pemdes')
                <a href="{{ route('pemdes.DistribusiBantuanShow', $data->id) }}" class="btn btn-custom">Lihat Detail</a>
                @endcan
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
