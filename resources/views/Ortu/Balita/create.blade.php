@extends('layout.main')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('title', 'Data Balita')
@section('judul', 'Data Balita')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-baby"></i> Tambah Data Balita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=""><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Tambah Data Balita</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    
                    {{-- Error Notification --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong><i class="fas fa-exclamation-triangle"></i> Oops!</strong> Ada kesalahan pada input Anda.
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Back Button --}}
                    <a href="{{ route('ortu.DataAnakIndex') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    {{-- Form --}}
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center">
                            <h3 class="card-title"><i class="fas fa-child"></i> Form Tambah Data Balita</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ortu.DataAnakStore') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <h5 class="mb-3 text-primary"><strong><i class="fas fa-user"></i> Data Balita Baru Lahir</strong></h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nik"><i class="fas fa-id-card"></i> NIK</label>
                                        <input type="number" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama"><i class="fas fa-user"></i> Nama</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir"><i class="fas fa-calendar-day"></i> Tanggal Lahir</label>
                                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                                    </div>                                
                                    <div class="col-md-6">
                                        <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="Laki-laki" class="form-check-input" required>
                                            <label for="jenis_kelamin_l" class="form-check-label">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="Perempuan" class="form-check-input">
                                            <label for="jenis_kelamin_p" class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="img"><i class="fas fa-camera"></i> Foto Si Kecil (Max 2MB)</label>
                                        <input type="file" name="img" id="img" class="form-control" accept="image/*" required onchange="previewImage(this)">
                                        <img src="" alt="Preview Foto" class="img-thumbnail img-preview mt-2" width="150px" style="display: none;">
                                    </div>
                                </div>

                                <h5 class="mt-4 text-primary"><strong><i class="fas fa-ruler"></i> Data Fisik</strong></h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="berat_badan"><i class="fas fa-weight"></i> Berat Badan (kg)</label>
                                        <input type="number" name="berat_badan" id="berat_badan" class="form-control" value="{{ old('berat_badan') }}" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tinggi_badan"><i class="fas fa-ruler-vertical"></i> Tinggi Badan (cm)</label>
                                        <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control" value="{{ old('tinggi_badan') }}" step="0.1" min="0" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lingkar_kepala"><i class="fas fa-circle"></i> Lingkar Kepala (cm)</label>
                                        <input type="number" name="lingkar_kepala" id="lingkar_kepala" class="form-control" value="{{ old('lingkar_kepala') }}" step="0.1" min="0" required>
                                    </div>
                                </div>

                                <h5 class="mt-4 text-primary"><strong><i class="fas fa-user-friends"></i> Data Ibu</strong></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nik_ibu"><i class="fas fa-id-card"></i> NIK Ibu</label>
                                        <input type="number" name="nik_ibu" id="nik_ibu" class="form-control @error('nik') is-invalid @enderror" value="{{ Auth::user()->nik }}" readonly>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_ibu"><i class="fas fa-user"></i> Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <h5 class="mt-4 text-primary"><strong><i class="fas fa-map-marked"></i> Alamat</strong></h5>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="alamat_lengkap"><i class="fas fa-address-card"></i> Alamat Lengkap</label>
                                        <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" required>{{ old('alamat_lengkap') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label for="rt"><i class="fas fa-map-marker-alt"></i> RT</label>
                                            <select name="rt" id="rt" class="form-control" required>
                                                <option value="">-- Pilih RT --</option>
                                                @for ($i = 1; $i <= 7; $i++)
                                                    <option value="{{ sprintf('%03d', $i) }}" {{ old('rt') == sprintf('%03d', $i) ? 'selected' : '' }}>
                                                        {{ sprintf('%03d', $i) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label for="rw"><i class="fas fa-map-signs"></i> RW</label>
                                            <select name="rw" id="rw" class="form-control" required>
                                                <option value="">-- Pilih RW --</option>
                                                @for ($i = 1; $i <= 8; $i++)
                                                    <option value="{{ sprintf('%03d', $i) }}" {{ old('rw') == sprintf('%03d', $i) ? 'selected' : '' }}>
                                                        {{ sprintf('%03d', $i) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                            <select name="posyandu" id="posyandu" class="form-control" required>
                                                <option value="">-- Pilih Posyandu --</option>
                                                @for ($i = 1; $i <= 8; $i++)
                                                    <option value="Posyandu Melati {{ $i }}" {{ old('posyandu') == "Posyandu Melati $i" ? 'selected' : '' }}>
                                                        Posyandu Melati {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
{{-- biar urutan dd-mm-yy --}}
<!-- Link JS untuk flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#tanggal_lahir", {
        dateFormat: "d-m-Y",       // Format yang dikirim ke server
        altInput: true,            // Tampilkan format alternatif
        altFormat: "d-m-Y",        // Format tampilan: dd-mm-yyyy
        allowInput: false
    });
</script>




<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.img-preview').src = e.target.result;
                document.querySelector('.img-preview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
