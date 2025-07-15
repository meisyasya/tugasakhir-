@extends('layout.main')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title', 'Edit Data Balita')
@section('judul', 'Edit Data Balita')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Balita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.DataAnakIndex') }}">Data Balita</a></li>
                        <li class="breadcrumb-item active">Edit Data Balita</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @can('post-admin')
            <a href="{{ route('admin.DataAnakIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @endcan
            @can('post-kader')
            <a href="{{ route('kader.DataAnakIndex') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @endcan

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Form Edit Data Balita</h3>
                </div>
                <div class="card-body">
                    @can('post-admin')
                    <form action="{{ route('admin.DataAnakUpdate', $balita->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $balita->nik }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $balita->nama }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $balita->tanggal_lahir }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-laki" {{ $balita->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $balita->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="berat_badan">Berat Badan (kg)</label>
                                    <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" value="{{ $balita->berat_badan }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                    <input type="number" step="0.1" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ $balita->tinggi_badan }}" required>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik_ibu">NIK Ibu</label>
                                    <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ $balita->nik_ibu }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ $balita->nama_ibu }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="alamat_lengkap">Alamat Lengkap</label>
                                    <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="2" required>{{ $balita->alamat_lengkap }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="posyandu">Posyandu</label>
                                    <input type="text" class="form-control" id="posyandu" name="posyandu" value="{{ $balita->posyandu }}" required>
                                </div>

                                

                                <div class="form-group">
                                    <label for="img">Foto Balita (opsional)</label>
                                    <input type="file" name="img" id="img" class="form-control" accept="image/*"  onchange="previewImage(this)">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                                    <br>
                                    <img src="{{ asset($balita->img) }}" alt="Foto Balita" class="img-thumbnail img-preview mt-2" width="150">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    @endcan

                    

                    @can('post-kader')
                    <form action="{{ route('kader.DataAnakUpdate', $balita->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $balita->nik }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $balita->nama }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $balita->tanggal_lahir }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-laki" {{ $balita->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $balita->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="berat_badan">Berat Badan (kg)</label>
                                    <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" value="{{ $balita->berat_badan }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                    <input type="number" step="0.1" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ $balita->tinggi_badan }}" required>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik_ibu">NIK Ibu</label>
                                    <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ $balita->nik_ibu }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ $balita->nama_ibu }}" required readonly>
                                </div>

                                <div class="form-group">
                                    <label for="alamat_lengkap">Alamat Lengkap</label>
                                    <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="2" required>{{ $balita->alamat_lengkap }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="posyandu">Posyandu</label>
                                    <input type="text" class="form-control" id="posyandu" name="posyandu" value="{{ $balita->posyandu }}" required>
                                </div>

                                

                                <div class="form-group">
                                    <label for="img">Foto Balita (opsional)</label>
                                    <input type="file" name="img" id="img" class="form-control" accept="image/*"  onchange="previewImage(this)">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                                    <br>
                                    <img src="{{ asset($balita->img) }}" alt="Foto Balita" class="img-thumbnail img-preview mt-2" width="150">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi flatpickr
        flatpickr("#tanggal_lahir", {
            dateFormat: "d-m-Y", // Format tampilan dd-mm-yy
        altInput: true,  // Gunakan input alternatif (bukan <input type="date">)
        altFormat: "d-m-Y",  // Format alternatif yang ditampilkan
        allowInput: false        });
    });
</script>
 {{-- Preview Image --}}
 <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                const imgPreview = document.querySelector('.img-preview');
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush