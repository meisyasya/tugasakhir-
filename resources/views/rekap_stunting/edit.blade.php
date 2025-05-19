@extends('layout.main')

@section('title', 'Edit Rekap Stunting')
@section('judul', 'Edit Rekap Stunting')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Rekap Stunting</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('bidan.RekapStuntingUpdate', $rekap->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Balita</label>
                            <input type="text" class="form-control" id="nama" value="{{ $rekap->balita->nama }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Diagnosis</label>
                            <input type="text" class="form-control" id="tanggal" value="{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Stunting</label>
                            <input type="text" class="form-control" id="status" value="{{ $rekap->status_stunting }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_bidan" class="form-label">Catatan Bidan</label>
                            <textarea name="catatan_bidan" id="catatan_bidan" rows="4" class="form-control" placeholder="Tulis catatan atau tindakan yang diberikan...">{{ old('catatan_bidan', $rekap->catatan_bidan) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('bidan.RekapStuntingIndex') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
