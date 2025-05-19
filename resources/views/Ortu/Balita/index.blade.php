@extends('layout.main')

@push('css')
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Data Balita')
@section('judul', 'Data Balita')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Balita</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <a href="{{ route('ortu.DataAnakCreate') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Data Balita
            </a>                        
            <div class="row">
                <div class="col-12">
                    {{-- Display Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    
                    {{-- Tabel Data Balita --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Balita</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="balitaTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Nama Ibu</th>
                                        <th>Posyandu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($balitas as $index => $balita)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $balita->nik }}</td>
                                            <td>{{ $balita->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') }}</td>
                                            <td>{{ $balita->user->name ?? '-' }}</td>
                                            <td>{{ $balita->posyandu }}</td>
                                            <td>
                                               {{-- Tombol Detail --}}
                                                <a href="{{ route('ortu.DataAnakShow', $balita->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('ortu.DataAnakEdit', $balita->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>          
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
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Menginisialisasi DataTable
            $('#balitaTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

        // Fungsi untuk mengkonfirmasi penghapusan data
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data balita ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengkonfirmasi, submit form
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Menampilkan SweetAlert untuk Flash Success Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 3000
            });
        @endif
    </script>
@endpush

@endsection
