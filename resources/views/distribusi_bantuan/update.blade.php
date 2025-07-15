@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-warning text-white text-center">
            <h4>Ubah Data Distribusi Bantuan</h4>
        </div>

        <div class="card-body">
            
            @can('post-admin')
            <form action="{{ route('admin.DistribusiBantuanUpdate', $distribusi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="diagnosis_id" value="{{ $distribusi->diagnosis_id }}">

                <div class="form-group mb-3">
                    <label for="balita_id">Nama Anak</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama }}" readonly>
                    <input type="hidden" name="balita_id" value="{{ $distribusi->balita->id }}">
                </div>
                <div class="form-group mb-3">
                    <label for="balita_id">Nama Ibu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama_ibu }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="kader">Nama Kader</label>
                    <input type="text" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="posyandu">Posyandu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->posyandu }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_distribusi">Tanggal Distribusi</label>
                    <input type="date" name="tanggal_distribusi" class="form-control" value="{{ $distribusi->tanggal_distribusi }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti (kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" name="foto_bukti" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" required>{{ $distribusi->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100">Perbarui Laporan</button>
            </form>
            @endcan
            @can('post-kader')
            <form action="{{ route('kader.DistribusiBantuanUpdate', $distribusi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="diagnosis_id" value="{{ $distribusi->diagnosis_id }}">

                <div class="form-group mb-3">
                    <label for="balita_id">Nama Anak</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama }}" readonly>
                    <input type="hidden" name="balita_id" value="{{ $distribusi->balita->id }}">
                </div>
                <div class="form-group mb-3">
                    <label for="balita_id">Nama Ibu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama_ibu }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="kader">Nama Kader</label>
                    <input type="text" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="posyandu">Posyandu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->posyandu }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_distribusi">Tanggal Distribusi</label>
                    <input type="date" name="tanggal_distribusi" class="form-control" value="{{ $distribusi->tanggal_distribusi }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti (kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" name="foto_bukti" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" required>{{ $distribusi->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100">Perbarui Laporan</button>
            </form>
            @endcan
            @can('post-bidan')
            <form action="{{ route('bidan.DistribusiBantuanUpdate', $distribusi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="diagnosis_id" value="{{ $distribusi->diagnosis_id }}">

                <div class="form-group mb-3">
                    <label for="balita_id">Nama Anak</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama }}" readonly>
                    <input type="hidden" name="balita_id" value="{{ $distribusi->balita->id }}">
                </div>
                <div class="form-group mb-3">
                    <label for="balita_id">Nama Ibu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->nama_ibu }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="kader">Nama Kader</label>
                    <input type="text" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="posyandu">Posyandu</label>
                    <input type="text" class="form-control" value="{{ $distribusi->balita->posyandu }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_distribusi">Tanggal Distribusi</label>
                    <input type="date" name="tanggal_distribusi" class="form-control" value="{{ $distribusi->tanggal_distribusi }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti (kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" name="foto_bukti" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control" required>{{ $distribusi->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100">Perbarui Laporan</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
