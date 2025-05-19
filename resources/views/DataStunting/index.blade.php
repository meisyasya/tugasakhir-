@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Data Balita Stunting')
@section('judul', 'Data Balita Stunting')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Balita Stunting</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger my-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Balita Stunting</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="diagnosisTable"> 
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>   
                                        <th>Nama Balita</th>
                                        <th>Tanggal Diagnosis</th>
                                        <th>Usia (bulan)</th>
                                        <th>Hasil Diagnosis</th>
                                        <th>Catatan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stuntingData as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data->balita->nama }}</td>
                                            <td>
                                                {{ $data->tanggal_diagnosis ? date('d-m-Y', strtotime($data->tanggal_diagnosis)) : '-' }}
                                            </td>                                                                                        <td>{{ $data->usia }}</td>
                                            <td>{{ $data->hasil_diagnosis }}</td>
                                            <td>{{ $data->status_gizi }}</td>
                                            <td>
                                                {{-- Misal tambahkan tombol detail kalau mau --}}
                                                <a href="{{ route('admin.DataStuntingsShow', $data->id) }}" class="btn btn-info btn-sm">Detail</a>
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

    <script>
        $(document).ready(function () {
            $('#diagnosisTable').DataTable();
        });
    </script>
@endpush

@endsection
