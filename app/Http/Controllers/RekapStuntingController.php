<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapStunting;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class RekapStuntingController extends Controller
{
    public function index(Request $request)
{
    $query = RekapStunting::with('balita')->orderBy('tanggal', 'desc');

    if ($request->filled('bulan')) {
        $year = date('Y', strtotime($request->bulan));
        $month = date('m', strtotime($request->bulan));
        $query->whereYear('tanggal', $year)
              ->whereMonth('tanggal', $month);
    }

    if ($request->filled('nama')) {
        $nama = $request->nama;
        $query->whereHas('balita', function ($q) use ($nama) {
            $q->where('nama', 'like', '%' . $nama . '%');
        });
    }

    $rekaps = $query->get();

    return view('rekap_stunting.index', compact('rekaps'));
}

public function edit($id)
{
    $rekap = RekapStunting::with('balita')->findOrFail($id);
    return view('rekap_stunting.edit', compact('rekap'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'catatan_bidan' => 'nullable|string|max:1000',
    ]);

    $rekap = RekapStunting::findOrFail($id);
    $rekap->update([
        'catatan_bidan' => $request->catatan_bidan,
    ]);

    return redirect()->route('bidan.RekapStuntingIndex')->with('success', 'Catatan berhasil diperbarui.');
}

public function cetakBulan(Request $request)
{
    $bulan = $request->bulan;

    if (!$bulan) {
        return redirect()->back()->with('error', 'Bulan harus dipilih.');
    }

    $tanggalBulan = Carbon::parse($bulan);
    $rekaps = RekapStunting::with('balita')
        ->whereMonth('tanggal', $tanggalBulan->month)
        ->whereYear('tanggal', $tanggalBulan->year)
        ->whereNotNull('status_stunting')
        ->orderBy('tanggal', 'asc')
        ->get();

    $pdf = Pdf::loadView('rekap_stunting.cetak_bulan', compact('rekaps', 'tanggalBulan'))
        ->setPaper('A4', 'landscape');

    $namaFile = 'Rekap-Stunting-Bulan-' . $tanggalBulan->format('F-Y') . '.pdf';
    return $pdf->stream($namaFile);
}

public function cetakTahun(Request $request)
{
    $tahun = $request->tahun;

    if (!$tahun) {
        return redirect()->back()->with('error', 'Tahun harus dipilih.');
    }

    $rekaps = RekapStunting::with('balita')
        ->whereYear('tanggal', $tahun)
        ->whereNotNull('status_stunting')
        ->orderBy('tanggal', 'asc')
        ->get();

    $pdf = Pdf::loadView('rekap_stunting.cetak_tahun', compact('rekaps', 'tahun'))
        ->setPaper('A4', 'landscape');

    $namaFile = 'Rekap-Stunting-Tahun-' . $tahun . '.pdf';
    return $pdf->stream($namaFile);
}



}
