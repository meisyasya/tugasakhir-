
@extends('layout.main')

@section('title')
    Data Kategori Artikel
@endsection
@section('judul')
Kategori Artikel
@endsection


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kategori Artikel</h1>
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
            <div class="col-12">
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
                  <h3 class="card-title">Data Kategori Artikel</h3>
  
                  
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
                                <!-- Delete Option -->
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                                  <i class="fas fa-trash-alt"></i> Delete
                                </a>

                            </div>
                        </div>
                    </td>
                   </tr>

                   {{-- modal --}}
     
                 @include('LandingPage.article.category.update-modal')
                 @include('LandingPage.article.category.delete-modal') 
                    
                   @endforeach

                   @include('LandingPage.article.category.create-modal')
                     
                        

                      
                    
                    </tbody>
                  </table>
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

