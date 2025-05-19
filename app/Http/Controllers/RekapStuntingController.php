<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapStunting;
use Carbon\Carbon;


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


}
