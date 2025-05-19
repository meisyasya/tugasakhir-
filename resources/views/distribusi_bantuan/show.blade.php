@extends('layout.main')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* General body and layout */
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Arial', sans-serif;
    }

    .container {
        display: flex;
        flex-direction: column;
        justify-content: center; /* Vertikal */
        align-items: center;     /* Horizontal */
        min-height: 100vh;
        background-color: #f8f9fa;
        padding: 20px;
    }

    .content {
    flex-grow: 0;
    width: 100%;
    max-width: 1200px;
    background-color: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-left: 250px; /* atau sesuai lebar sidebar kamu */
}


    footer {
        margin-top: auto;
        padding: 10px 0;
        background-color: #f1f3f5;
        text-align: center;
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Card Header */
    .card-header-custom {
        background-color: #4f8cf3;
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 1.2rem;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
    }

    /* Card Styles */
    .card-custom {
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    /* Info Row */
    .info-row {
        margin-bottom: 1rem;
        font-size: 1.1rem;
        color: #495057;
    }

    .info-row strong {
        color: #343a40;
    }

    /* Highlight Text for 'Stunting' */
    .highlight-text {
        color: #e74c3c;
        font-weight: bold;
    }

    /* Buttons Styling */
    .btn-custom {
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 30px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-custom-success {
        background-color: #28a745;
        color: white;
    }

    .btn-custom-success:hover {
        background-color: #218838;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    .btn-custom-back {
        background-color: #6c757d;
        color: white;
    }

    .btn-custom-back:hover {
        background-color: #5a6268;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    /* Layout Adjustments */
    .row {
        margin-bottom: 2rem;
    }

    @media (max-width: 767px) {
        .btn-custom {
            width: 100%;
        }
    }
</style>
@endpush

@section('title', 'Detail Balita')
@section('judul', 'Detail Balita')

@section('content')
<div class="container py-4">
    <div class="content">
        <div class="row">
            <!-- INFORMASI BALITA -->
            <div class="col-12 col-md-6 mb-2">
                <div class="card card-custom">
                    <div class="card-header card-header-custom">INFORMASI BALITA</div>
                    <div class="card-body">
                        <div class="info-row"><strong>Nama</strong>: {{ $diagnosis->balita->nama }}</div>
                        <div class="info-row"><strong>NIK</strong>: {{ $diagnosis->balita->nik }}</div>
                        <div class="info-row"><strong>Tanggal Lahir</strong>: {{ \Carbon\Carbon::parse($diagnosis->balita->tanggal_lahir)->format('d-m-Y') }}</div>
                        <div class="info-row"><strong>Jenis Kelamin</strong>: {{ $diagnosis->balita->jenis_kelamin }}</div>
                        <div class="info-row"><strong>Nama Ibu</strong>: {{ $diagnosis->balita->nama_ibu }}</div>
                        <div class="info-row"><strong>Alamat</strong>: {{ $diagnosis->balita->alamat_lengkap }}</div>
                    </div>
                </div>
            </div>

            <!-- HASIL DIAGNOSIS -->
            <div class="col-12 col-md-6 mb-4">
                <div class="card card-custom">
                    <div class="card-header card-header-custom">HASIL DIAGNOSIS</div>
                    <div class="card-body">
                        <div class="info-row"><strong>Tanggal Diagnosis</strong>: {{ \Carbon\Carbon::parse($diagnosis->tanggal_diagnosis)->format('d-m-Y') }}</div>
                        <div class="info-row"><strong>Usia</strong>: {{ $diagnosis->usia }}</div>
                        <div class="info-row"><strong>Berat Badan</strong>: {{ $diagnosis->bb }} kg</div>
                        <div class="info-row"><strong>Tinggi Badan</strong>: {{ $diagnosis->tb }} cm</div>
                        <div class="info-row"><strong>IMT</strong>: {{ $diagnosis->imt }}</div>
                        <div class="info-row"><strong>Status Gizi</strong>: {{ $diagnosis->status_gizi }}</div>
                        <div class="info-row">
                            <strong>Status Stunting</strong>: 
                            <span class="{{ strtolower($diagnosis->hasil_diagnosis) == 'stunting berat' ? 'highlight-text' : '' }}">
                                {{ $diagnosis->hasil_diagnosis }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Upload Laporan -->
        <div class="d-flex justify-content-between gap-2 mb-4">
            <a href="{{ route('admin.DistribusiBantuanCreate', ['id' => $diagnosis->id]) }}" class="btn btn-custom btn-custom-success">
                Upload Laporan
            </a>
        </div>

        <!-- Daftar Distribusi Bantuan -->
        <div class="card card-custom">
            <div class="card-header card-header-custom">Daftar Distribusi Bantuan</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Distribusi</th>
                            <th>Foto Bukti</th>
                            <th>Keterangan</th>
                            <th>Nama Kader</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($distribusiBantuan as $index => $bantuan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($bantuan->tanggal_distribusi)->translatedFormat('l, d F Y') }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$bantuan->foto_bukti) }}" alt="Foto Bukti" width="100">
                                </td>
                                <td>{{ $bantuan->keterangan }}</td>
                                <td>{{ Auth::user()->name }}</td>
                                <td>
                                    <!-- Form Hapus dengan Modal -->
                                    <form action="{{ route('admin.DistribusiBantuanDelete', $bantuan->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <!-- Tombol buka modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $bantuan->id }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>

                                        <!-- Modal konfirmasi hapus -->
                                        <div class="modal fade" id="hapusModal{{ $bantuan->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $bantuan->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusModalLabel{{ $bantuan->id }}">Konfirmasi Penghapusan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.DistribusiBantuanEdit', $bantuan->id) }}" class="btn btn-sm btn-warning ms-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('admin.DistribusiBantuanIndex') }}" class="btn btn-custom btn-custom-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Bootstrap JS dan dependensi Popper (Pastikan sudah dipanggil) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
@endpush
