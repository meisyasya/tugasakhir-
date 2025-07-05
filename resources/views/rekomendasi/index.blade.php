@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@endpush

@section('title', 'Data Rekomendasi')
@section('judul', 'Rekomendasi')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Rekomendasi</h1>
                </div>
            </div>
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
                <div class="card-header">
                    <h3 class="card-title">Tabel Rekomendasi</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Jenis Stunting</th>
                                <th>Rekomendasi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekomendasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->jenis_stunting }}</td>
                                    <td>{!! $item->rekomendasi !!}</td>
                                    @can('post-admin')
                                    <td class="text-center">
                                        <a href="{{ route('admin.RekomendasiEdit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pen"></i> Update
                                        </a>
                                    </td>
                                    @endcan
                                    @can('post-bidan')
                                    <td class="text-center">
                                        <a href="{{ route('bidan.RekomendasiEdit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pen"></i> Update
                                        </a>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush