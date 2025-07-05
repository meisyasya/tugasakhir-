@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white text-center">
            <h4>Formulir Distribusi Bantuan</h4>
        </div>

        <div class="card-body">
            @can('post-admin')
            <form action="{{ route('admin.DistribusiBantuanStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Gunakan rekap_stunting_id sesuai controller -->
                <input type="hidden" name="rekap_stunting_id" value="{{ $diagnosis->id }}">

                <!-- Nama Anak -->
                <div class="form-group mb-3">
                    <label for="balita_nama">Nama Anak</label>
                    <input type="text" id="balita_nama" class="form-control" value="{{ $diagnosis->balita->nama }}" readonly>
                    <input type="hidden" name="balita_id" value="{{ $diagnosis->balita->id }}">
                </div>

                <!-- Nama Ibu -->
                <div class="form-group mb-3">
                    <label for="nama_ibu">Nama Ibu</label>
                    <input type="text" id="nama_ibu" class="form-control" value="{{ $diagnosis->balita->nama_ibu }}" readonly>
                </div>

                <!-- Nama Kader -->
                <div class="form-group mb-3">
                    <label for="kader">Nama Kader</label>
                    <input type="text" id="kader" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>

                <!-- Posyandu -->
                <div class="form-group mb-3">
                    <label for="posyandu">Posyandu</label>
                    <input type="text" id="posyandu" class="form-control" value="{{ $diagnosis->balita->posyandu }}" readonly>
                </div>

                <!-- Tanggal Distribusi -->
                <div class="form-group mb-3">
                    <label for="tanggal_distribusi">Tanggal Distribusi</label>
                    <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="form-control" required>
                </div>

                <!-- Foto Bukti -->
                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti</label>
                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control" required>
                </div>

                <!-- Keterangan -->
                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Laporan</button>
            </form>
            @endcan

            @can('post-kader')
            <form action="{{ route('kader.DistribusiBantuanStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Gunakan rekap_stunting_id sesuai controller -->
                <input type="hidden" name="rekap_stunting_id" value="{{ $diagnosis->id }}">

                <!-- Nama Anak -->
                <div class="form-group mb-3">
                    <label for="balita_nama">Nama Anak</label>
                    <input type="text" id="balita_nama" class="form-control" value="{{ $diagnosis->balita->nama }}" readonly>
                    <input type="hidden" name="balita_id" value="{{ $diagnosis->balita->id }}">
                </div>

                <!-- Nama Ibu -->
                <div class="form-group mb-3">
                    <label for="nama_ibu">Nama Ibu</label>
                    <input type="text" id="nama_ibu" class="form-control" value="{{ $diagnosis->balita->nama_ibu }}" readonly>
                </div>

                <!-- Nama Kader -->
                <div class="form-group mb-3">
                    <label for="kader">Nama Kader</label>
                    <input type="text" id="kader" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>

                <!-- Posyandu -->
                <div class="form-group mb-3">
                    <label for="posyandu">Posyandu</label>
                    <input type="text" id="posyandu" class="form-control" value="{{ $diagnosis->balita->posyandu }}" readonly>
                </div>

                <!-- Tanggal Distribusi -->
                <div class="form-group mb-3">
                    <label for="tanggal_distribusi">Tanggal Distribusi</label>
                    <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="form-control" required>
                </div>

                <!-- Foto Bukti -->
                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti</label>
                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control" required>
                </div>

                <!-- Keterangan -->
                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Laporan</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
