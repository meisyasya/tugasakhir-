@extends('layout.main')

@section('title', 'Detail Data Stunting')
@section('judul', 'Detail Balita Stunting')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Detail Balita Stunting</h4>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Informasi Balita</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Nama</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->nama }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>NIK</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->nik }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Tanggal Lahir</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->tanggal_lahir ? \Carbon\Carbon::parse($diagnosis->balita->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Jenis Kelamin</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->jenis_kelamin }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Nama Ibu</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->nama_ibu }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Alamat</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->balita->alamat_lengkap }}, RT {{ $diagnosis->balita->rt }}/RW {{ $diagnosis->balita->rw }}</div>
                    </div>
                </li>
            </ul>
        
            <h5 class="mb-3">Hasil Diagnosis</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Tanggal Diagnosis</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ \Carbon\Carbon::parse($diagnosis->tanggal_diagnosis)->format('d-m-Y') }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Usia</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->usia }} bulan</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Berat Badan</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->bb }} kg</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Tinggi Badan</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->tb }} cm</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>IMT</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->imt }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Status Gizi</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7">{{ $diagnosis->status_gizi }}</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-4"><strong>Status Stunting</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-7 text-danger fw-bold">{{ $diagnosis->hasil_diagnosis }}</div>
                    </div>
                </li>
            </ul>
        
            <div class="mt-4">
                <a href="{{ route('admin.DataStuntingIndex') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </div>
        
    </div>
</div>
@endsection
