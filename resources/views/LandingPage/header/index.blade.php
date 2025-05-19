@extends('layout.main')

@push('css')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet');

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
    font-family: 'Patrick Hand', cursive;
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
</style>
@endpush

@section('title', 'Header')
@section('judul', 'Landing Page')
@section('subjudul', 'Header')

@section('content')

<div class="content-wrapper">
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Data Header</h3>
            </div>
            <div class="card-body p-4">
              <section id="hero" class="hero">
                <div class="container">
                  <div class="about-img">
                    @if ($header->image)
                      <img src="{{ asset('storage/header/' . $header->image) }}" class="img-fluid" alt="Gambar SIPENTING">
                    @else
                      <p>Data belum tersedia</p>
                    @endif
                  </div>
                  <div class="text-content">
                    <h2>{{ $header->title ?? 'Data belum tersedia' }}</h2>
                    <p>{{ $header->description ?? 'Data belum tersedia' }}</p>
                  </div>
                </div>
              </section>
    
              <section id="data-form" class="data-form">
              <div class="container">
               <h2 class="text-center mt-5">Form Pengisian Header</h2>
              <form action="{{ route('admin.headerupdate', $header->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" id="title" name="title" value="{{ $header->title }}" >
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="3" >{{ $header->description }}</textarea>
                </div>
                <div class="form-group">
                  <label for="image">Image</label>
                  <small>(Max 2 MB)</small>
                  <input type="file" name="image" class="form-control" id="image" accept="image/*"  onchange="previewImage(this)">
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
          </div>
        </div>
      </div>
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