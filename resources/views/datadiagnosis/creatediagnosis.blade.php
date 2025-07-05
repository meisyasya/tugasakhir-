@extends('layout.main')

@section('title', 'Diagnosis Stunting')
@section('judul', 'Diagnosis Stunting')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Diagnosis Stunting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Diagnosis Stunting</li>
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
                    <!-- Error Notification -->
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

                    <!-- Card Form -->
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-baby"></i> Form Tambah Data Diagnosis</h3>
                        </div>
                        <div class="card-body">

                            @can('post-admin')
                            <form action="{{ route('admin.DataDiagnosisStore') }}" method="POST">
                                @csrf

                                <h5 class="mb-3"><strong>📝 Data Balita </strong></h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nik"><i class="fas fa-id-card"></i> NIK</label>
                                            <input type="number" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama"><i class="fas fa-user"></i> Nama</label>
                                            <select name="nama" id="nama" class="form-control select2" required>
                                                <option value="" hidden>-- choose --</option>
                                                @foreach ($balitas as $item)
                                                    <option value="{{ $item->id }}" 
                                                        data-nik="{{ $item->nik }}" 
                                                        data-jenis_kelamin="{{ $item->jenis_kelamin }}" 
                                                        data-posyandu="{{ $item->posyandu }} "
                                                        data-tanggal-lahir="{{ $item->tanggal_lahir }}"
                                                        data-nama-ibu="{{ $item->nama_ibu }}">
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir"><i class="fas fa-calendar-alt"></i> Tanggal Lahir</label>
                                            <!-- Tanggal Lahir asli (untuk form processing) -->
                                            <input type="hidden" name="tanggal_lahir" id="tanggal_lahir">

                                            <!-- Tampilan format dd-mm-yy -->
                                            <input type="text" class="form-control" id="tanggal_lahir_display" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                            <input type="text" name="posyandu" id="posyandu" class="form-control" value="{{ old('posyandu') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nama_ibu"><i class="fas fa-female"></i> Nama Ibu</label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" readonly>
                                </div>

                                <h5 class="mb-3"><strong>📊 Data Pertumbuhan</strong></h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="berat_badan"><i class="fas fa-weight"></i> Berat Badan (kg)</label>
                                            <input type="number" name="berat_badan" id="berat_badan" class="form-control" value="{{ old('berat_badan') }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_badan"><i class="fas fa-ruler-vertical"></i> Tinggi Badan (cm)</label>
                                            <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control" value="{{ old('tinggi_badan') }}" step="0.1" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lingkar_kepala"><i class="fas fa-head-side-mask"></i> Lingkar Kepala (cm)</label>
                                            <input type="number" name="lingkar_kepala" id="lingkar_kepala" class="form-control" value="{{ old('lingkar_kepala') }}" step="0.1" min="0" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal Pencatatan -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_pencatatan"><i class="fas fa-calendar-day"></i> Tanggal Pencatatan</label>
                                            <input type="date" name="tanggal_pencatatan" id="tanggal_pencatatan" class="form-control" value="{{ old('tanggal_pencatatan') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center w-100">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan Data
                                    </button>
                                </div>
                            </form>
                            @endcan

                            @can('post-kader')
                            <form action="{{ route('kader.DataDiagnosisStore') }}" method="POST">
                                @csrf

                                <h5 class="mb-3"><strong>📝 Data Balita </strong></h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nik"><i class="fas fa-id-card"></i> NIK</label>
                                            <input type="number" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama"><i class="fas fa-user"></i> Nama</label>
                                            <select name="nama" id="nama" class="form-control select2" required>
                                                <option value="" hidden>-- choose --</option>
                                                @foreach ($balitas as $item)
                                                    <option value="{{ $item->id }}" 
                                                        data-nik="{{ $item->nik }}" 
                                                        data-jenis_kelamin="{{ $item->jenis_kelamin }}" 
                                                        data-posyandu="{{ $item->posyandu }} "
                                                        data-tanggal-lahir="{{ $item->tanggal_lahir }}"
                                                        data-nama-ibu="{{ $item->nama_ibu }}">
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir"><i class="fas fa-calendar-alt"></i> Tanggal Lahir</label>
                                            <!-- Tanggal Lahir asli (untuk form processing) -->
                                            <input type="hidden" name="tanggal_lahir" id="tanggal_lahir">

                                            <!-- Tampilan format dd-mm-yy -->
                                            <input type="text" class="form-control" id="tanggal_lahir_display" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="posyandu"><i class="fas fa-clinic-medical"></i> Posyandu</label>
                                            <input type="text" name="posyandu" id="posyandu" class="form-control" value="{{ old('posyandu') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nama_ibu"><i class="fas fa-female"></i> Nama Ibu</label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" readonly>
                                </div>

                                <h5 class="mb-3"><strong>📊 Data Pertumbuhan</strong></h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="berat_badan"><i class="fas fa-weight"></i> Berat Badan (kg)</label>
                                            <input type="number" name="berat_badan" id="berat_badan" class="form-control" value="{{ old('berat_badan') }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_badan"><i class="fas fa-ruler-vertical"></i> Tinggi Badan (cm)</label>
                                            <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control" value="{{ old('tinggi_badan') }}" step="0.1" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lingkar_kepala"><i class="fas fa-head-side-mask"></i> Lingkar Kepala (cm)</label>
                                            <input type="number" name="lingkar_kepala" id="lingkar_kepala" class="form-control" value="{{ old('lingkar_kepala') }}" step="0.1" min="0" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal Pencatatan -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_pencatatan"><i class="fas fa-calendar-day"></i> Tanggal Pencatatan</label>
                                            <input type="date" name="tanggal_pencatatan" id="tanggal_pencatatan" class="form-control" value="{{ old('tanggal_pencatatan') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center w-100">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan Data
                                    </button>
                                </div>
                            </form>
                            @endcan
                        </div>
                    </div> <!-- End Card -->
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
<!-- jQuery dan Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi Select2
        $('#nama').select2({
            placeholder: "-- pilih nama balita --",
            allowClear: true,
            width: '100%'
        });

        // Ketika nama balita dipilih
        $('#nama').on('change', function () {
            let selected = $(this).find(':selected');

            if (selected.val()) {
                $('#nik').val(selected.data('nik'));
                $('#posyandu').val(selected.data('posyandu')?.trim());
                $('#tanggal_lahir').val(selected.data('tanggal-lahir'));
                $('#nama_ibu').val(selected.data('nama-ibu'));
            } else {
                // Kosongkan jika tidak ada yang dipilih
                $('#nik').val('');
                $('#posyandu').val('');
                $('#tanggal_lahir').val('');
                $('#nama_ibu').val('');
            }
        });
    });

    function formatTanggal(tanggal) {
    if (!tanggal) return '';

    // Parsing manual agar tidak tergantung locale
    const parts = tanggal.split('-'); // diasumsikan format: yyyy-mm-dd
    const year = parts[0];  // ambil dua digit terakhir tahun
    const month = parts[1];
    const day = parts[2];

    return `${day}-${month}-${year}`;
}

$('#nama').on('change', function () {
    let selected = $(this).find(':selected');

    if (selected.val()) {
        const tanggalLahir = selected.data('tanggal-lahir');
        $('#tanggal_lahir').val(tanggalLahir); // untuk disimpan ke database
        $('#tanggal_lahir_display').val(formatTanggal(tanggalLahir)); // untuk ditampilkan
    } else {
        $('#tanggal_lahir').val('');
        $('#tanggal_lahir_display').val('');
    }
});


</script>
@endpush

@endsection
