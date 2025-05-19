@extends('layout.main')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
@endpush

@section('title', 'Update Rekomendasi')
@section('judul', 'Update Rekomendasi')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Update Rekomendasi</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if ($errors->any())
                <div class="alert alert-danger my-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.RekomendasiUpdate', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jenis_stunting">Jenis Stunting</label>
                            <input type="text" name="jenis_stunting" id="jenis_stunting" class="form-control" value="{{ old('jenis_stunting', $item->jenis_stunting) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="rekomendasi">Rekomendasi</label>
                            <textarea name="rekomendasi" id="rekomendasi" class="form-control">{{ old('rekomendasi', $item->rekomendasi) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        <a href="{{ route('admin.RekomendasiIndex') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#rekomendasi').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']]
                ]
            });
        });
    </script>
@endpush
