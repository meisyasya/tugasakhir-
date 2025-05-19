@extends('layout.main')

{{-- Panggil CSS --}}
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@endpush

@section('title', 'Data Artikel')
@section('judul', 'Data Artikel')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Artikel</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- Tombol Tambah Artikel --}}
                    <a href="{{ route('admin.ArticleCreate') }}" class="btn btn-success mb-3">Tambah Artikel</a>

                    {{-- Tampilkan Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- SweetAlert --}}
                    <div class="swal" data-swal="{{ session('success') }}"></div>

                    {{-- Tabel Artikel --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Artikel</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Views</th>
                                        <th>Status</th>
                                        <th>Tanggal Publikasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $index => $article)
                                        <tr>
                                            <td>{{ $articles->firstItem() + $index }}</td>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ $article->category->name ?? '-' }}</td>
                                            <td>{{ $article->views }}</td>
                                            <td>
                                                @if ($article->status == 0)
                                                    <span class="badge bg-danger">Private</span>
                                                @else
                                                    <span class="badge bg-success">Published</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($article->publish_date)->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.ArticleShow', $article->id) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.ArticleEdit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm" onclick="deleteArticle({{ $article->id }})">Hapus</button>
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data artikel.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            

                            <div class="mt-3">
                                {{ $articles->links() }}
                            </div>

                            
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Script --}}
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swal = $('.swal').data('swal');
        if (swal) {
            Swal.fire({
                title: 'Success',
                text: swal,
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            });
        }

        function deleteArticle(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Artikel ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/article/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
@endsection
