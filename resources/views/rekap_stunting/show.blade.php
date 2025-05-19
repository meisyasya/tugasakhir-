@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Data Rekap Stunting</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('rekap.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded">
            + Tambah Data
        </a>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama Balita</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Catatan Bidan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekaps as $i => $rekap)
                <tr>
                    <td class="border px-4 py-2">{{ $i + 1 }}</td>
                    <td class="border px-4 py-2">{{ $rekap->balita->nama }}</td>
                    <td class="border px-4 py-2">{{ $rekap->tanggal }}</td>
                    <td class="border px-4 py-2">{{ $rekap->status_stunting }}</td>
                    <td class="border px-4 py-2">{{ $rekap->catatan_bidan ?? '-' }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('rekap.edit', $rekap->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
