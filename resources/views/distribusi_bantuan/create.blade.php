@extends('layout.main')

@section('title', 'Formulir Distribusi Bantuan')
@section('judul', 'Formulir Distribusi Bantuan') {{-- Tambahkan judul untuk breadcrumb/header --}}

@push('css')
<style>
    /* Style untuk image preview */
    .image-preview {
        max-width: 150px; /* Lebar maksimum yang lebih kecil */
        max-height: 150px; /* Tinggi maksimum yang lebih kecil */
        height: auto;
        display: block; /* Agar gambar tidak inline */
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        object-fit: contain; /* Memastikan gambar tidak terdistorsi dan pas di dalam kotaknya */
    }
    /* Sembunyikan image preview secara default */
    .image-preview:not([src]) {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Formulir Distribusi Bantuan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Formulir Distribusi Bantuan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8"> {{-- Ukuran kolom disesuaikan --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> Ada kesalahan pada input Anda.
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card shadow rounded">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Formulir Distribusi Bantuan</h4>
                        </div>

                        <div class="card-body">
                            @can('post-admin')
                            <form action="{{ route('admin.DistribusiBantuanStore') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="rekap_stunting_id" value="{{ $diagnosis->id }}">

                                <div class="form-group mb-3">
                                    <label for="balita_nama"><i class="fas fa-baby"></i> Nama Anak</label>
                                    <input type="text" id="balita_nama" class="form-control" value="{{ $diagnosis->balita->nama }}" readonly>
                                    <input type="hidden" name="balita_id" value="{{ $diagnosis->balita->id }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama_ibu"><i class="fas fa-female"></i> Nama Ibu</label>
                                    <input type="text" id="nama_ibu" class="form-control" value="{{ $diagnosis->balita->nama_ibu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="kader"><i class="fas fa-user-shield"></i> Nama Kader</label>
                                    <input type="text" id="kader" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                    <input type="text" id="posyandu" class="form-control" value="{{ $diagnosis->balita->posyandu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal_distribusi"><i class="fas fa-calendar-alt"></i> Tanggal Distribusi</label>
                                    <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="foto_bukti"><i class="fas fa-camera"></i> Foto Bukti</label>
                                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*" required>
                                    @error('foto_bukti')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- Image preview area --}}
                                    <img id="imagePreview" class="image-preview" src="#" alt="Preview Gambar">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="keterangan"><i class="fas fa-info-circle"></i> Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Laporan</button>
                            </form>
                            @endcan

                            @can('post-kader')
                            <form action="{{ route('kader.DistribusiBantuanStore') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="rekap_stunting_id" value="{{ $diagnosis->id }}">

                                <div class="form-group mb-3">
                                    <label for="balita_nama"><i class="fas fa-baby"></i> Nama Anak</label>
                                    <input type="text" id="balita_nama" class="form-control" value="{{ $diagnosis->balita->nama }}" readonly>
                                    <input type="hidden" name="balita_id" value="{{ $diagnosis->balita->id }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama_ibu"><i class="fas fa-female"></i> Nama Ibu</label>
                                    <input type="text" id="nama_ibu" class="form-control" value="{{ $diagnosis->balita->nama_ibu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="kader"><i class="fas fa-user-shield"></i> Nama Kader</label>
                                    <input type="text" id="kader" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                    <input type="text" id="posyandu" class="form-control" value="{{ $diagnosis->balita->posyandu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal_distribusi"><i class="fas fa-calendar-alt"></i> Tanggal Distribusi</label>
                                    <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="foto_bukti"><i class="fas fa-camera"></i> Foto Bukti</label>
                                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*" required>
                                    @error('foto_bukti')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- Image preview area --}}
                                    <img id="imagePreview" class="image-preview" src="#" alt="Preview Gambar">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="keterangan"><i class="fas fa-info-circle"></i> Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Laporan</button>
                            </form>
                            @endcan


                            @can('post-bidan')
                            <form action="{{ route('bidan.DistribusiBantuanStore') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="rekap_stunting_id" value="{{ $diagnosis->id }}">

                                <div class="form-group mb-3">
                                    <label for="balita_nama"><i class="fas fa-baby"></i> Nama Anak</label>
                                    <input type="text" id="balita_nama" class="form-control" value="{{ $diagnosis->balita->nama }}" readonly>
                                    <input type="hidden" name="balita_id" value="{{ $diagnosis->balita->id }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama_ibu"><i class="fas fa-female"></i> Nama Ibu</label>
                                    <input type="text" id="nama_ibu" class="form-control" value="{{ $diagnosis->balita->nama_ibu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="kader"><i class="fas fa-user-shield"></i> Nama Kader</label>
                                    <input type="text" id="kader" name="kader" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                    <input type="text" id="posyandu" class="form-control" value="{{ $diagnosis->balita->posyandu }}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal_distribusi"><i class="fas fa-calendar-alt"></i> Tanggal Distribusi</label>
                                    <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="foto_bukti"><i class="fas fa-camera"></i> Foto Bukti</label>
                                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*" required>
                                    @error('foto_bukti')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- Image preview area --}}
                                    <img id="imagePreview" class="image-preview" src="#" alt="Preview Gambar">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="keterangan"><i class="fas fa-info-circle"></i> Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Laporan</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoBuktiInput = document.getElementById('foto_bukti');
        const imagePreview = document.getElementById('imagePreview');

        fotoBuktiInput.addEventListener('change', function() {
            const file = this.files[0]; // Ambil file pertama yang dipilih

            if (file) {
                const reader = new FileReader(); // Buat objek FileReader
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Set sumber gambar ke data URL hasil baca file
                    imagePreview.style.display = 'block'; // Tampilkan gambar
                };
                reader.readAsDataURL(file); // Baca file sebagai Data URL
            } else {
                imagePreview.src = '#'; // Reset sumber gambar
                imagePreview.style.display = 'none'; // Sembunyikan gambar
            }
        });
    });
</script>
@endpush