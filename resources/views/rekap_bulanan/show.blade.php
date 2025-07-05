@extends('layout.main')

@section('title', 'Detail Rekap Bulanan')
@section('judul', 'Detail Rekap Bulanan')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Rekap Bulanan</h1>
                </div><div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        {{-- Rute breadcrumb disesuaikan berdasarkan peran --}}
                        @can('post-admin')
                            <li class="breadcrumb-item"><a href="{{ route('admin.rekapBulananIndex') }}">Rekap Bulanan</a></li>
                        @endcan
                        @can('post-kader')
                            <li class="breadcrumb-item"><a href="{{ route('kader.rekapBulananIndex') }}">Rekap Bulanan</a></li>
                        @endcan
                        @can('post-bidan')
                            <li class="breadcrumb-item"><a href="{{ route('bidan.rekapBulananIndex') }}">Rekap Bulanan</a></li>
                        @endcan
                        <li class="breadcrumb-item active">Detail Rekap Bulanan</li>
                    </ol>
                </div></div></div></div>
    <section class="content">
        <div class="container-fluid">
            @can('post-admin')
            <a href="{{ route('admin.rekapBulananIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @endcan
            @can('post-kader')
            <a href="{{ route('kader.rekapBulananIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @endcan
            @can('post-bidan')
            <a href="{{ route('bidan.rekapBulananIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @endcan

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-child"></i> Informasi Balita & Ibu</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%;">Tanggal Rekap</th>
                                        <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 40%;">Nama Balita</th>
                                        <td>{{ $rekap->balita->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td>{{ $rekap->balita->nama_ibu ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Posyandu</th>
                                        <td>{{ $rekap->balita->posyandu ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title"><i class="fas fa-chart-line"></i> Data Pertumbuhan</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%;">Usia</th>
                                        <td>{{ $rekap->usia }} bulan</td>
                                    </tr>
                                    <tr>
                                        <th>Berat Badan</th>
                                        <td>{{ $rekap->bb }} kg</td>
                                    </tr>
                                    <tr>
                                        <th>Tinggi Badan</th>
                                        <td>{{ $rekap->tb }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>Lingkar Kepala</th>
                                        <td>{{ $rekap->lingka_kepala }} cm</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow mt-3"> {{-- mt-3 untuk jarak antar kartu --}}
                        <div class="card-header bg-warning text-dark">
                            <h3 class="card-title"><i class="fas fa-notes-medical"></i> Hasil Diagnosis & Gizi</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%;">Hasil Diagnosis</th>
                                        <td>{{ $rekap->hasil_diagnosis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Gizi</th>
                                        <td>{{ $rekap->status_gizi }}</td>
                                    </tr>
                                    <tr>
                                        <th>IMT</th>
                                        <td>{{ $rekap->imt}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div></section>
    </div>
@endsection