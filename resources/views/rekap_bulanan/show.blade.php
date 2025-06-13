@extends('layout.main')

@section('title', 'Detail Rekap Bulanan')
@section('judul', 'Detail Rekap Bulanan')

@section('content')
<div class="container mt-4">
    <h4>Detail Rekap Tanggal: {{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}</h4>

    <table class="table table-bordered">
        <tr>
            <th>Nama Balita</th>
            <td>{{ $rekap->balita->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Balita</th>
            <td>{{ $rekap->balita->nama_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <th>Posyandu</th>
            <td>{{ $rekap->balita->posyandu ?? '-' }}</td>
        </tr>
        <tr>
            <th>Usia</th>
            <td>{{ $rekap->usia }} bulan</td>
        </tr>
        <tr>
            <th>Berat Badan</th>
            <td>{{ $rekap->bb }} kg</td>
        </tr>
        <tr>
            <th>Tinggi Badan</th>
            <td>{{ $rekap->tb }} cm</td>
        </tr>
        <tr>
            <th>Lingkar Kepala</th>
            <td>{{ $rekap->lingka_kepala }} cm</td>
        </tr>
        <tr>
            <th>Hasil Diagnosis</th>
            <td>{{ $rekap->hasil_diagnosis }} </td>
        </tr>
        <tr>
            <th>Status Gizi</th>
            <td>{{ $rekap->status_gizi }} cm</td>
        </tr>
        <tr>
            <th>IMT</th>
            <td>{{ $rekap->imt}} cm</td>
        </tr>
        
        
        
    </table>

    <a href="{{ route('bidan.rekapBulananIndex') }}" class="btn btn-secondary">← Kembali</a>
</div>
@endsection
