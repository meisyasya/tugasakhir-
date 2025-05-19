@extends('layout.main')

@section('title', 'Detail Data Balita')
@section('judul', 'Detail Data Balita')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Data Balita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ortu.DataAnakIndex') }}">Data Balita</a></li>
                        <li class="breadcrumb-item active">Detail Data Balita</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Tombol Kembali -->
            <a href="{{ route('ortu.DataAnakIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="row">
                <!-- Data Anak -->
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Informasi Balita</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{ asset($balita->img) }}" alt="Foto Balita" class="img-thumbnail" width="200">
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $balita->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $balita->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $balita->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Berat Badan</th>
                                    <td>{{ $balita->berat_badan }} kg</td>
                                </tr>
                                <tr>
                                    <th>Tinggi Badan</th>
                                    <td>{{ $balita->tinggi_badan }} cm</td>
                                </tr>
                                <tr>
                                    <th>Lingkar Kepala</th>
                                    <td>{{ $balita->lingkar_kepala }} cm</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">Informasi Ibu</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>NIK Ibu</th>
                                    <td>{{ $balita->nik_ibu }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td>{{ $balita->nama_ibu }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-warning text-dark">
                            <h3 class="card-title">Alamat & Posyandu</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>{{ $balita->alamat_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>RT</th>
                                    <td>{{ $balita->rt }}</td>
                                </tr>
                                <tr>
                                    <th>RW</th>
                                    <td>{{ $balita->rw }}</td>
                                </tr>
                                <tr>
                                    <th>Posyandu</th>
                                    <td>{{ $balita->posyandu }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tombol Edit -->
                <div class="col-12">
                    <div class="text-center mt-3">
                        <a href="{{ route('ortu.DataAnakEdit', $balita->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
