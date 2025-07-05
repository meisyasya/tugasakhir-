@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Data Diagnosis')
@section('judul', 'Data Diagnosis')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Diagnosis</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(auth()->user()->can('post-admin'))
                    <a href="{{  route('admin.DataDiagnosisCreate') }}" class="btn btn-success mb-3" >Tambah Diagnosis Stunting</a>
                    @endif

                    @if(auth()->user()->can('post-kader'))
                    <a href="{{  route('kader.DataDiagnosisCreate') }}" class="btn btn-success mb-3" >Tambah Diagnosis Stunting</a>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger my-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Diagnosis</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="diagnosisTable"> 
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Balita</th>
                                        <th>Tanggal Diagnosis</th>
                                        <th>Usia (bulan)</th>
                                        <th>Berat Badan (kg)</th>
                                        <th>Tinggi Badan (cm)</th>
                                        <th>Lingkar Kepala (cm)</th>
                                        <th>IMT</th>
                                        <th>Status Gizi</th>
                                        <th>Hasil Diagnosis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diagnoses as $index => $diagnosis)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $diagnosis->balita->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($diagnosis->tanggal_diagnosis)->format('d-m-Y') }}</td>
                                            <td>{{ $diagnosis->usia }} bulan</td>
                                            <td>{{ $diagnosis->bb }} kg</td>
                                            <td>{{ $diagnosis->tb }} cm</td>
                                            <td>{{ $diagnosis->lingkar_kepala }} cm</td>
                                            <td>{{ $diagnosis->imt }}</td>
                                            <td>{{ $diagnosis->status_gizi }}</td>
                                            <td>{{ $diagnosis->hasil_diagnosis }}</td>
                                            <td>
                                                <div class="row g-2">
                                                    @can('post-admin')
                                                        <div class="col-auto">
                                                            <button class="btn btn-danger btn-sm btn-delete w-100" data-id="{{ $diagnosis->id }}">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                            <form id="form-delete-{{ $diagnosis->id }}" action="{{ route('admin.DataDiagnosisDelete', $diagnosis->id) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    @endcan

                                                    @can('post-kader')
                                                        <div class="col-auto">
                                                            <button class="btn btn-danger btn-sm btn-delete w-100" data-id="{{ $diagnosis->id }}">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                            <form id="form-delete-{{ $diagnosis->id }}" action="{{ route('kader.DataDiagnosisDelete', $diagnosis->id) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    @endcan

                                                  
                                
                                                    @can('post-admin')
                                                    <div class="col-auto">
                                                        <form action="{{ route('admin.DataDiagnosisAcc', $diagnosis->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                                <i class="fas fa-check"></i> ACC
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @endcan

                                                    @can('post-kader')
                                                    <div class="col-auto">
                                                        <form action="{{ route('kader.DataDiagnosisAcc', $diagnosis->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                                <i class="fas fa-check"></i> ACC
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#diagnosisTable').DataTable();
        });
    </script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif
</script>



<script>
    $(document).ready(function () {
        $('#diagnosisTable').DataTable();

       

        $('.btn-delete').click(function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data diagnosis akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-' + id).submit();
                }
            });
        });
    });
</script>


@endpush

@endsection
