
@extends('layout.main')

@section('title')
    Data Galeri
@endsection
@section('judul')
    Data Galeri
@endsection


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kategori Galeri</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
   
        <div class="row">
            <div class="col-md-6">
              {{-- data prestasi --}}
              <a href="" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah Data</a>
              @if ($errors->any())
              <div class="my-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
                @endif



                @session('success')
                    
                <div class="my-3">
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
              </div>
                @endsession
                
            

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Kategori Makanan</h3>
  
                 
                </div>
                <!-- /.card-header -->
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
                       {{-- membuat nomer otomatis --}}
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $item->name }}</td>
                       <td>{{ $item->slug }}</td>
                       <td>{{ $item->created_at }}</td>
                       <td>
                  <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-cogs"></i> Aksi
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                          <!-- Edit Option -->
                          <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item->id }}">
                              <i class="fas fa-pen"></i> Edit
                          </a>
                          <!-- Hapus Option -->
                          <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                              <i class="fas fa-trash-alt"></i> Hapus
                          </a>
                      </div>
                  </div>
              </td>
                   </tr>

                   {{-- modal --}}
                   
                    @include('LandingPage.galeri.update-category') 
                    @include('LandingPage.galeri.delete-category') 
                    
                   @endforeach
                   
                   @include('LandingPage.galeri.create-category')

                   <!-- Modal -->
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>



            {{-- tambah menu makanan --}}
            <div class="col-md-6">
              {{-- Tombol Tambah Article --}}
               <a href="{{ route('admin.GaleriCreate') }}" class="btn btn-success mb-3" >Tambah Galeri</a> 
              
              {{-- Tampilkan error validasi --}}
              @if ($errors->any())
                  <div class="alert alert-danger my-3">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
          
              {{-- Tampilkan pesan sukses --}}
              {{-- @if (session('success'))
                  <div class="alert alert-success my-3">
                      {{ session('success') }}
                  </div>
              @endif --}}
          
              {{--  sweet alert--}}
              <div class="swal" data-swal="{{ session('success') }}"></div>
          
              {{-- Tabel Data --}}
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title">Data Galeri</h3>
                  </div>
                  <!-- /.card-header -->


                  
                  
                    <!-- /.card-header -->
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
                              @foreach ($galeris as $item)
                              <tr>
                                  {{-- membuat nomer otomatis --}}
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $item->title }}</td>
                                  <td>{{ $item->category->name ?? 'Tidak ada kategori' }}</td>
                                  <td>{!! $item->desc !!}</td>
                                  <td> 
                                    <img src="{{ asset('storage/' . $item->img) }}" alt="Image" width="200" height="auto">
                                </td>
                                
                                <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
  
                                  <td>
                             <div class="dropdown">
                                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="fas fa-cogs"></i> Aksi
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                     <!-- Edit Option -->
                                     <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalUpdateMenu{{ $item->id }}">
                                         <i class="fas fa-pen"></i> Edit
                                     </a>
                                     <!-- Hapus Option -->
                                     <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDeleteMenu{{ $item->id }}">
                                         <i class="fas fa-trash-alt"></i> Hapus
                                     </a>
                                 </div>
                             </div>
                         </td>
                              </tr>
           
                              {{-- modal --}}
                               @include('LandingPage.galeri.update-galeri') 
                               @include('LandingPage.galeri.delete-galeri')   
                               
                              @endforeach
                              
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>



                  <!-- /.card-body -->
              </div>
              <!-- /.card -->
          
          </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


   
  </div>

@endsection


@push('js')
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
   

    // Image Preview function (support multiple modals)
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

