@extends('layout.main')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Rekap Stunting')
@section('judul', 'Rekap Stunting')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rekap Stunting</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <form method="GET" class="row mb-3 align-items-end">
                <div class="col-md-3">
                    <label for="bulan" class="form-label">Filter Bulan</label>
                    <input type="month" name="bulan" id="bulan" class="form-control" value="{{ request('bulan') }}">
                </div>
                <div class="col-md-3">
                    <label for="nama" class="form-label">Nama Balita</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Aisyah" value="{{ request('nama') }}">
                </div>
                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('bidan.RekapStuntingIndex') }}" class="btn btn-secondary me-2">Reset</a>

                    @if(request('bulan'))
                        <a href="{{ route('bidan.RekapStuntingCetakBulan', ['bulan' => request('bulan')]) }}" target="_blank" class="btn btn-success me-2">
                            <i class="fas fa-print"></i> Cetak Bulan
                        </a>
                    @endif

                    @if(request('bulan'))
                        @php
                            $tahun = \Carbon\Carbon::parse(request('bulan'))->format('Y');
                        @endphp
                        <a href="{{ route('bidan.RekapStuntingCetakTahun', ['tahun' => $tahun]) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-calendar-alt"></i> Cetak Tahun
                        </a>
                    @endif
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Rekap Stunting</h3>
                </div>
                <div class="card-body">
                    <table id="rekapTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Balita</th>
                                <th>Nama Ibu</th>
                                <th>Tanggal</th>
                                <th>Usia (bln)</th>
                                <th>BB (kg)</th>
                                <th>TB (cm)</th>
                                <th>IMT</th>
                                <th>Status Stunting</th>
                                <th>Catatan Bidan</th>
                                @can('post-bidan')
                                <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekaps as $i => $rekap)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $rekap->balita->nama }}</td>
                                <td>{{ $rekap->balita->nama_ibu }}</td>
                                <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $rekap->usia }}</td>
                                <td>{{ $rekap->bb }}</td>
                                <td>{{ $rekap->tb }}</td>
                                <td>{{ $rekap->imt }}</td>
                                <td>{{ $rekap->status_stunting }}</td>
                                <td>{{ $rekap->catatan_bidan ?? '-' }}</td>
                                @can('post-bidan')
                                <td>
                                    <a href="{{ route('bidan.RekapStuntingEdit', $rekap->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
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

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#rekapTable').DataTable({
            "ordering": true,
            "pageLength": 10,
            "lengthChange": false,
            "searching": false,
            "info": true,
            "autoWidth": false,
        });
    });

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
@endpush

@endsection