@extends('layout.main')

@section('title', 'Data Artikel')
@section('judul', 'Data Artikel')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5" style="min-height: 85vh;">
    <div class="w-100" style="max-width: 900px;">

        <h1 class="h3 mb-4 text-center">Tambah Data Artikel</h1>

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <a href="{{ route('admin.ArticleIndex') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form action="{{ route('admin.ArticleStore') }}" method="POST" enctype="multipart/form-data" class="card shadow-lg border-primary p-4">
            @csrf
        
            <div class="row">
                {{-- Title --}}
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control border border-primary" value="{{ old('title') }}" required>
                </div>
        
                {{-- Category --}}
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select border border-primary" required>
                        <option value="" hidden>-- Pilih Kategori --</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
        
            {{-- Description --}}
            <div class="mb-3">
                <label for="desc" class="form-label">Deskripsi</label>
                <textarea name="desc" id="desc" class="form-control border border-primary" rows="4" placeholder="Tulis deskripsi artikel...">{{ old('desc') }}</textarea>
            </div>
        
            {{-- Image --}}
            <div class="mb-3">
                <label for="img" class="form-label">Gambar (Max 2MB)</label>
                <input type="file" name="img" id="img" class="form-control border border-primary" accept="image/*" required onchange="previewImage(this)">
                <div class="mt-3">
                    <img src="" alt="Preview Gambar" class="img-thumbnail d-none" id="imagePreview" style="max-width: 150px;">
                </div>
            </div>
        
            <div class="row">
                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select border border-primary" required>
                        <option value="" hidden>-- Pilih Status --</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>
        
                {{-- Publish Date --}}
                <div class="col-md-6 mb-3">
                    <label for="publish_date" class="form-label">Tanggal Publikasi</label>
                    <input type="date" name="publish_date" id="publish_date" class="form-control border border-primary" value="{{ old('publish_date') }}" required>
                </div>
            </div>
        
            {{-- Submit Button --}}
            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">Simpan</button>
            </div>
        </form>
        
    </div>
</div>

{{-- Preview Gambar --}}
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
