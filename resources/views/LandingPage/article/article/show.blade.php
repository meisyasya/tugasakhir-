@extends('layout.main')


<style>
    .margin-top {
    margin-top: 20px; /* Adjust the value as needed */
    }
</style>
@section('title', 'Detail Artikel')
@section('judul', 'Detail Artikel')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Artikel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                       
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- Detail Article Card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Detail Artikel</h3>
                </div>
                <!-- /.card-header -->
      
                <div class="card-body">
                  <table class="table table-striped table-bordered">
                    <tr>
                      <th width="250px">Judul</th>
                      <td>{{ $article->title }}</td>
                    </tr>
                    <tr>
                      <th>Kategori</th>
                      <td>{{ $article->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                      <th>Deskripsi</th>
                      <td>{!! $article->desc !!}</td>
                    </tr>
                    <tr>
                      <th>Gambar</th>
                      <td>
                        <a href="{{ asset('storage/uploads/articles/'.$article->img) }}" target="_blank" rel="noopener noreferrer">
                          <img src="{{ asset('storage/uploads/articles/'.$article->img) }}" alt="{{ $article->title }}" class="img-fluid" style="max-width: 30%;">
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th>Views</th>
                      <td>{{ $article->views }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td>
                        @if ($article->status == 1)
                          <span class="badge bg-success">Published</span>
                        @else
                          <span class="badge bg-danger">Private</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Tanggal Publikasi</th>
                      <td>{{ \Carbon\Carbon::parse($article->publish_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                      <th>Penulis</th>
                      <td>{{ $article->user->name ?? '-' }}</td>
                    </tr>
                  </table>
      
                  <div class="float-end" style="margin-top: 20px;">
                    <a href="{{ route('admin.ArticleIndex') }}" class="btn btn-secondary">Kembali</a>
                  </div>
      
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
    <!-- /.content -->
</div>

<br>
<br>
@endsection
