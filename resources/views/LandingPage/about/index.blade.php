@extends('layout.main')

@push('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f0f8ff; /* Biru muda sangat terang */
        color: #333; /* Warna teks gelap */
    }

    .content-wrapper {
        padding-top: 20px;
    }

    .section-header p {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
    }

    .section-header span {
        font-weight: bold;
    }

    .about .content p {
        text-align: center;
        font-size: 1.1em;
        line-height: 1.6;
        color: #666;
    }

    .why-us {
        background-color: #fff;
        padding: 30px 0;
        text-align: center;
    }

    .why-us img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
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

    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <p><span>{{ $about->title ?? 'Data belum tersedia' }}</span></p>
            </div>

            <div class="row gy-5">
                <div class="col-lg-20 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
                    <div class="content ps-5 ps-lg-5">
                        <p>{{ $about->description ?? 'Data belum tersedia' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="why-us" class="why-us section-bg">
        @if ($about->image)
                      <img src="{{ asset('storage/about/' . $about->image) }}" class="img-fluid" alt="Gambar SIPENTING">
                    @else
                      <p>Data belum tersedia</p>
                    @endif
    </section>

    <!-- Form Pengisian Data -->
    <section id="data-form" class="data-form">
        <div class="container">
            <h2 class="text-center mt-5">Form Pengisian About</h2>
            <form action="{{ route('admin.aboutupdate', $about->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')  <!-- Tambahkan ini untuk menandakan bahwa ini adalah permintaan PUT -->
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul" value="{{ $about->title }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukkan deskripsi" required>{{ $about->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <small>(Max 2 MB)</small>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(this)">
                    <img id="img-preview" src="" alt="Image Preview" width="100" style="display: none; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">
                </div>
                <div class="col-12 d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </section>

    
</div>
@endsection


@push('js')
<script>
  // img preview
  function previewImage(input) {
        var preview = document.getElementById('img-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Menampilkan gambar pratinjau
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Menyembunyikan gambar pratinjau jika tidak ada file
        }
    }
</script>
    
@endpush