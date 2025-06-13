@extends('layout.main')

@section('title')
    Data Kategori Makanan
@endsection

@section('judul')
    Kategori Makanan
@endsection

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Menu Makanan</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Kategori Makanan (1/3) -->
                <div class="col-md-4">
                    <a href="" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah Data</a>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Kategori Makanan</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i> Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item->id }}">
                                                        <i class="fas fa-pen"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @include('LandingPage.MenuMakanan.update-modalcategory') 
                                    @include('LandingPage.MenuMakanan.delete-modalcategory') 
                                    @endforeach

                                    @include('LandingPage.MenuMakanan.create-modalcategory')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Menu Makanan (2/3) -->
                <div class="col-md-8">
                    <a href="{{ route('admin.MenuMakananCreate') }}" class="btn btn-success mb-3">Tambah Menu Makanan</a>

                    <div class="swal" data-swal="{{ session('success') }}"></div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Menu Makanan</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="dataTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Image</th>
                                        <th>Publish Date</th>
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menumakanan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->category->name ?? 'Tidak ada kategori' }}</td>
                                        <td style="max-width: 300px; white-space: normal;">
                                            {!! Str::limit(strip_tags($item->desc), 200, '...') !!}
                                        </td>
                                        <td>
                                            @if (!empty($item->img) && $item->img !== 'logo.png')
                                                <img src="{{ asset('storage/' . $item->img) }}" alt="Image" width="120" class="img-fluid rounded">
                                            @else
                                                <p class="text-muted">Foto belum tersedia</p>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i> Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalUpdateMenu{{ $item->id }}">
                                                        <i class="fas fa-pen"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDeleteMenu{{ $item->id }}">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @include('LandingPage.MenuMakanan.updateMenu-modalmenu') 
                                    @include('LandingPage.MenuMakanan.deleteMenu-modalmenu') 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col-md-8 -->
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
    @foreach ($menumakanan as $item)
        CKEDITOR.replace('desc{{ $item->id }}', {
            filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
        });
    @endforeach

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
