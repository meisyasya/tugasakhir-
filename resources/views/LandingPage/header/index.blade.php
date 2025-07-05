@extends('layout.main')

{{-- Push custom CSS to the head section --}}
@push('css')
<style>
    /* Import Google Fonts for better typography */
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

    /* Styles for the hero section - though not directly used on this form page, kept for completeness */
    .hero {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
        padding: 60px 0;
    }
    .hero .container {
        display: flex;
        align-items: center;
        max-width: 1200px;
    }
    .hero .about-img {
        flex: 1;
        text-align: center;
    }
    .hero .about-img img {
        max-width: 100%;
        border-radius: 10px;
    }
    .hero .text-content {
        flex: 1;
        padding-left: 40px;
        text-align: left;
        /* Jika ingin menggunakan font ini, pastikan sudah diimport dari Google Fonts */
        /* font-family: 'Patrick Hand', cursive; */
    }
    .hero h2 {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
    }
    .hero p {
        font-size: 1.2rem;
        color: #555;
    }

    /* Styles for the update button */
    .btn-update {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
    }
    .btn-update:hover {
        background-color: #0056b3;
    }

    /* Image display styling for both current and preview images */
    .img-thumbnail-display {
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        margin-top: 10px;
        max-width: 150px; /* Batasi lebar gambar */
        height: auto; /* Jaga aspek rasio */
        object-fit: cover; /* Pastikan gambar mengisi area tanpa distorsi */
    }
</style>
@endpush

{{-- Set the page title and breadcrumbs --}}
@section('title', 'Header')
@section('judul', 'Landing Page')
@section('subjudul', 'Header')

{{-- Main content section --}}
@section('content')
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary">Data Header</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Header</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- /.content-header --}}

    {{-- Main content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Edit Data Header</h3>
                        </div>
                        {{-- /.card-header --}}

                        <div class="card-body p-4">
                            <section id="data-form" class="data-form">
                                <div class="container">
                                    <h2 class="text-center mb-4">Form Pengisian Header</h2>
                                    <form action="{{ route('admin.headerupdate', $header->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        {{-- Input Judul --}}
                                        <div class="form-group mb-3">
                                            <label for="title">Judul</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $header->title) }}" required>
                                            @error('title')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Input Deskripsi --}}
                                        <div class="form-group mb-3">
                                            <label for="description">Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $header->description) }}</textarea>
                                            @error('description')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Unggah Gambar --}}
                                        <div class="form-group mb-4">
                                            <label for="image">Gambar</label>
                                            <small class="text-muted">(Ukuran Maks. 2 MB, format: JPG, PNG, JPEG)</small>
                                            <input type="file" name="image" class="form-control-file" id="image" accept="image/*" onchange="previewImage(event)">
                                            
                                            {{-- Tampilan Gambar Saat Ini (jika ada) --}}
                                            @if($header->image)
                                                <div id="current-image-container" class="mt-2">
                                                    <p class="mb-1">Gambar Saat Ini:</p>
                                                    {{-- PENTING: Jika di controller Anda menyimpan 'header/namafile.ext', maka ini sudah benar --}}
                                                    <img src="{{ asset('storage/header/' . $header->image) }}" alt="Gambar Header Saat Ini" id="current-image" class="img-thumbnail-display">
                                                </div>
                                            @else
                                                {{-- Jika tidak ada gambar saat ini, tampilkan pesan --}}
                                                <div id="current-image-container" class="mt-2">
                                                    <p class="mb-1 text-muted">Belum ada gambar yang diunggah.</p>
                                                </div>
                                            @endif
                                            
                                            {{-- Preview Gambar Baru (akan muncul saat file dipilih) --}}
                                            {{-- Awalnya tersembunyi, hanya tampil saat file dipilih oleh JS --}}
                                            <div id="new-image-preview-container" class="mt-2" style="display: none;">
                                                <p class="mb-1">Pratinjau Gambar Baru:</p>
                                                <img id="img-preview" src="#" alt="Pratinjau Gambar Baru" class="img-thumbnail-display">
                                            </div>

                                            @error('image')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Tombol Submit --}}
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-edit me-2"></i> Perbarui Header
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                        {{-- /.card-body --}}
                    </div>
                    {{-- /.card --}}
                </div>
            </div>
        </div>
    </section>
    {{-- /.content --}}
</div>
@endsection

{{-- Push custom JavaScript to the end of the body section --}}
@push('js')
<script>
    /**
     * Mempratinjau gambar yang dipilih sebelum diunggah dan mengelola visibilitas gambar saat ini/baru.
     * @param {Event} event - Event 'change' dari input file.
     */
    function previewImage(event) {
        const input = event.target;
        const imgPreview = document.getElementById('img-preview');
        const currentImageContainer = document.getElementById('current-image-container');
        const newImagePreviewContainer = document.getElementById('new-image-preview-container');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block'; // Tampilkan pratinjau gambar baru

                // Sembunyikan gambar saat ini jika ada gambar baru yang dipilih
                if (currentImageContainer) {
                    currentImageContainer.style.display = 'none';
                }
                newImagePreviewContainer.style.display = 'block'; // Pastikan kontainer pratinjau baru terlihat
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Tidak ada file yang dipilih, kembali menampilkan gambar saat ini jika ada
            imgPreview.src = '#';
            imgPreview.style.display = 'none'; // Sembunyikan pratinjau gambar baru

            if (currentImageContainer) {
                currentImageContainer.style.display = 'block'; // Tampilkan kembali gambar saat ini
            }
            newImagePreviewContainer.style.display = 'none'; // Sembunyikan kontainer pratinjau baru jika tidak ada file
        }
    }

    // Pastikan status awal kontainer pratinjau gambar sudah benar saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const currentImage = document.getElementById('current-image');
        const newImagePreviewContainer = document.getElementById('new-image-preview-container');
        const imgPreview = document.getElementById('img-preview'); // Ambil referensi ke img-preview

        if (currentImage) {
            // Jika ada gambar saat ini, sembunyikan kontainer pratinjau gambar baru secara default
            // Ini akan muncul hanya ketika pengguna memilih file baru
            if (newImagePreviewContainer) {
                newImagePreviewContainer.style.display = 'none';
            }
        } else {
            // Jika tidak ada gambar saat ini, pastikan kontainer pratinjau gambar baru terlihat
            // Tetapi gambar pratinjaunya sendiri tetap tersembunyi sampai file dipilih
            if (newImagePreviewContainer) {
                newImagePreviewContainer.style.display = 'block';
                if (imgPreview) {
                    imgPreview.style.display = 'none';
                }
            }
        }
    });
</script>
@endpush