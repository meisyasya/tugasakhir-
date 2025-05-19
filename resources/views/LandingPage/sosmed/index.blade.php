@extends('layout.main')
<style>
  .wrap-text {
      white-space: normal; /* Allow text to wrap */
      max-width: 500px;    /* Set a maximum width */
  }
</style>

@section('title')
   Sosial Media
@endsection

@section('judul')
   Sosial Media
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Sosial Media</h1>
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

                <a href="{{ route('admin.SosmedCreate') }}" class="btn btn-success mb-3">Tambah Data</a>
                
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Data Sosial Media</h3>
                      <div class="card-tools">
                       
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>URL</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($socialMedias as $socialMedia)
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $socialMedia->name }}</td>
                              <td><i class="{{ $socialMedia->icon_class }}"></i></td>
                              <td class="wrap-text"><a href="{{ $socialMedia->url }}" target="_blank">{{ $socialMedia->url }}</a></td>
                              <td>
                                <div class="dropdown">
                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $socialMedia->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="fas fa-cogs"></i> Aksi
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $socialMedia->id }}">
                                      <li>
                                          <a href="{{ route('admin.SosmedEdit', ['sosmed' => $socialMedia->id]) }}" class="dropdown-item text-warning">
                                              <i class="fas fa-pen"></i> Edit
                                          </a>
                                      </li>
                                      <li>
                                          <a data-toggle="modal" data-target="#modal-hapus{{ $socialMedia->id }}" class="dropdown-item text-danger">
                                              <i class="fas fa-trash-alt"></i> Hapus
                                          </a>
                                      </li>
                                  </ul>
                              </div> 
                              </td>
                          </tr>
                          
                          <!-- Modal Konfirmasi Hapus -->
                          <div class="modal fade" id="modal-hapus{{ $socialMedia->id }}">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <p>Apakah kamu yakin akan menghapus data <b>{{ $socialMedia->name }}</b>?</p>
                                      </div>
                                      <div class="modal-footer justify-content-between">
                                           <form action="{{ route('admin.SosmedDelete', ['sosmed' => $socialMedia->id]) }}" method="post">
                                              @csrf
                                              @method('delete')
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-danger">Ya, Hapus data</button>
                                          </form> 
                                      </div>
                                  </div>
                                  <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                          </div>
                          <!-- End Modal -->
                          @endforeach
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
