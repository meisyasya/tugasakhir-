@extends('layout.main')

{{-- Push custom CSS to the head section --}}
@push('css')
<style>
    /* Import Google Fonts for better typography */
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
    /* Note: 'Roboto' was in your original CSS, I've kept the common imports.
             If 'Roboto' is specifically needed for *this* page, ensure it's imported. */

    /* Basic body styles (from original) */
    body {
        font-family: 'Open Sans', sans-serif; /* Changed to common font */
        background-color: #f0f8ff; /* Biru muda sangat terang */
        color: #333; /* Warna teks gelap */
    }

    .content-wrapper {
        padding-top: 20px;
    }

    /* Styles for the section header */
    .section-header {
        text-align: center;
        margin-bottom: 40px; /* Add some space below header */
    }

    .section-header p {
        font-size: 2.5em; /* Larger font for main title */
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .section-header span {
        color: #007bff; /* Highlight the span */
    }

    /* Styles for the about content */
    .about .content p {
        text-align: justify; /* Changed to justify for better reading */
        font-size: 1.1em;
        line-height: 1.8; /* Increased line-height for readability */
        color: #555;
        max-width: 900px; /* Limit width for long text */
        margin-left: auto;
        margin-right: auto;
        padding: 0 15px; /* Add padding for smaller screens */
    }

    /* Styles for the image section */
    .why-us {
        background-color: #fff;
        padding: 40px 0; /* More padding */
        text-align: center;
        margin-top: 30px; /* Space above image section */
        border-radius: 8px; /* Slightly rounded corners for card-like effect */
        box-shadow: 0 4px 8px rgba(0,0,0,0.05); /* Subtle shadow */
    }

    .why-us img {
        max-width: 80%; /* Adjusted max-width */
        height: auto;
        border-radius: 10px; /* Rounded corners for the image */
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Stronger shadow for image */
    }

    /* Form specific styles */
    .data-form .card {
        margin-top: 40px; /* Space above the form card */
    }

    /* Image display styling for both current and preview images in the form */
    .img-thumbnail-display {
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        margin-top: 10px;
        max-width: 150px; /* Ensure images don't stretch */
        height: auto;
        object-fit: cover; /* Ensure image covers the area */
    }

    /* Adjust button styles for consistency */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 25px; /* Larger padding for button */
        font-size: 1.1rem;
        border-radius: 8px; /* More rounded button */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endpush

@section('title', 'About')
@section('judul', 'Landing Page')
@section('subjudul', 'About')

@section('content')
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary">Data About</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">About</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- /.content-header --}}

   

    {{-- Form for editing About data --}}
    <section id="data-form" class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Form Pengisian Data About</h3>
                        </div>
                        {{-- /.card-header --}}

                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Perbarui Data About</h2>
                            <form action="{{ route('admin.aboutupdate', $about->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Judul Input --}}
                                <div class="form-group mb-3">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $about->title) }}" required>
                                    @error('title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi Textarea --}}
                                <div class="form-group mb-3">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $about->description) }}</textarea>
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
                                    @if($about->image)
                                        <div id="current-image-container" class="mt-2">
                                            <p class="mb-1">Gambar Saat Ini:</p>
                                            {{-- Path disesuaikan dengan asumsi disimpan di 'storage/app/public/about/' --}}
                                            <img src="{{ asset('storage/about/' . $about->image) }}" alt="Gambar About Saat Ini" id="current-image" class="img-thumbnail-display">
                                        </div>
                                    @else
                                        <div id="current-image-container" class="mt-2">
                                            <p class="mb-1 text-muted">Belum ada gambar yang diunggah.</p>
                                        </div>
                                    @endif
                                    
                                    {{-- Pratinjau Gambar Baru (akan muncul saat file dipilih) --}}
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
                                        <i class="fas fa-edit me-2"></i> Perbarui Data About
                                    </button>
                                </div>
                            </form>
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
        const imgPreview = document.getElementById('img-preview');

        // Jika tidak ada gambar saat ini (misal $about->image kosong)
        if (!currentImage) {
            if (newImagePreviewContainer) {
                newImagePreviewContainer.style.display = 'block'; // Tampilkan kontainer pratinjau baru
                if (imgPreview) {
                    imgPreview.style.display = 'none'; // Tapi gambar pratinjaunya sendiri tersembunyi
                }
            }
        } else {
            // Jika ada gambar saat ini, sembunyikan kontainer pratinjau baru secara default
            if (newImagePreviewContainer) {
                newImagePreviewContainer.style.display = 'none';
            }
        }
    });
</script>
@endpush