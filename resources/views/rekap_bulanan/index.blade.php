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

            <div class="accordion" id="rekapAccordion">
                @forelse($rekaps as $tanggal => $items)
                    @php $slug = \Illuminate\Support\Str::slug($tanggal); @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $slug }}">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $slug }}"
                                aria-expanded="false" aria-controls="collapse{{ $slug }}">
                                Tanggal: {{ $tanggal }}
                            </button>
                        </h2>
                        <div id="collapse{{ $slug }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $slug }}" data-bs-parent="#rekapAccordion">
                            <div class="accordion-body">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Balita</th>
                                            <th>Usia (bulan)</th>
                                            <th>BB (kg)</th>
                                            <th>TB (cm)</th>
                                            <th>IMT</th>
                                            <th>Status Gizi</th>
                                            <th>Hasil Diagnosis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $rekap)
                                            <tr>
                                                <td>{{ $rekap->balita->nama }}</td>
                                                <td>{{ $rekap->usia }}</td>
                                                <td>{{ $rekap->bb }}</td>
                                                <td>{{ $rekap->tb }}</td>
                                                <td>{{ $rekap->imt }}</td>
                                                <td>{{ $rekap->status_gizi }}</td>
                                                <td>{{ $rekap->hasil_diagnosis }}</td>
                                            </tr>
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
