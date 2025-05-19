
@extends('layout.main')

@section('title')
    Data Pengguna
@endsection
@section('judul')
    Pengguna
@endsection


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pengguna</h1>
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
              @if(auth()->user()->hasRole('admin'))
              <a href="" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">Register</a>
              @endif
          
      
              
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
                  <h3 class="card-title">Data Pengguna</h3>
  
                  <div class="card-tools">
                    <form action="{{ route('admin.UsersIndex') }}" method="GET">
                      <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Search" value="{{ request('table_search') }}">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-default">
                                  <i class="fas fa-search"></i>
                              </button>
                          </div>
                      </div>
                  </form>
                  
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Foto</th>
                        <th>No Telp</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                         
                   @foreach ($users as $item)
                   <tr>
                       {{-- membuat nomer otomatis --}}
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $item->name }}</td>
                       <td>{{ $item->nik }}</td>
                       <td>{{ $item->email }}</td>
                       <td>{{ $item->getRoleNames()->first() ?? '-' }}</td> {{-- Role --}}
                       <td>
                        @if ($item->photo && \Illuminate\Support\Facades\Storage::exists('public/' . $item->photo))
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto" width="100" height="100" class="img-circle">
                        @else
                            <span class="text-muted">Foto belum tersedia</span>
                        @endif
                        </td>
                        <td>{{ $item->phone }}</td>
                    
                    
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d-m-Y') }}</td>
                        <td class="text-center">
                        <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item->id }}">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                       
                        @if (!$item->hasRole('admin'))
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                @endif


                    
                                     
                       </td>
                   </tr>

                   {{-- modal --}}
                   
                   @endforeach
                   
                   @include('users.create-modal') 
                    @include('users.update-modal')  
                     @include('users.delete-modal')
                     
                        

                      
                    
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

