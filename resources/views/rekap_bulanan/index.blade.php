@extends('layout.main')

@section('title', 'Rekap Bulanan')
@section('judul', 'Rekap Bulanan')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    .accordion-button {
        background-color: #eaf4ff;
        font-weight: 600;
    }
    .accordion-item {
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .accordion-body {
        background-color: #f9fcff;
    }
    table th, table td {
        vertical-align: middle !important;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Rekap Bulanan Diagnosis</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form pencarian global --}}
            <form method="GET" action="{{ route('bidan.rekapBulananIndex') }}" class="mb-3">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama balita..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

            <div class="accordion" id="rekapAccordion">
                @php
                    $search = request('search');
                @endphp

                @forelse($rekaps as $tanggal => $items)
                    @php 
                        $slug = \Illuminate\Support\Str::slug($tanggal);
                        $isOpen = false;

                        if ($search) {
                            foreach ($items as $rekap) {
                                if (stripos($rekap->balita->nama ?? '', $search) !== false) {
                                    $isOpen = true;
                                    break;
                                }
                            }
                        }
                    @endphp

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $slug }}">
                            <button class="accordion-button {{ $isOpen ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $slug }}"
                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="collapse{{ $slug }}">
                                Tanggal: {{ $tanggal }}
                            </button>
                        </h2>
                        <div id="collapse{{ $slug }}" class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                            aria-labelledby="heading{{ $slug }}" data-bs-parent="#rekapAccordion">
                            <div class="accordion-body">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-semibold">Total Balita: {{ count($items) }} balita</span>
                                    <a href="{{ route('bidan.rekap.print', ['tanggal' => $tanggal]) }}" target="_blank" class="btn btn-success">
                                        <i class="fas fa-print"></i> Cetak Absensi
                                    </a>
                                </div>

                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Balita</th>
                                            <th>Posyandu</th>
                                            <th>Usia (bulan)</th>
                                            <th>BB (kg)</th>
                                            <th>TB (cm)</th>
                                            <th>Lingkar Kepala</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $rekap)
                                            @if (!$search || stripos($rekap->balita->nama ?? '', $search) !== false)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $rekap->balita->nama ?? '-' }}</td>
                                                    <td>{{ $rekap->balita->posyandu ?? '-' }}</td>
                                                    <td>{{ $rekap->usia }} bulan</td>
                                                    <td>{{ $rekap->bb }} kg</td>
                                                    <td>{{ $rekap->tb }} cm</td>
                                                    <td>{{ $rekap->lingkar_kepala }} cm</td>
                                                    <td>
                                                        <a href="{{ route('bidan.rekap.show', $rekap->id) }}" class="btn btn-sm btn-primary">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info mt-3">
                        Tidak ada data rekap bulanan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
