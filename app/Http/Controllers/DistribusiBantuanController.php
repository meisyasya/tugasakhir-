<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DistribusiBantuan;
use App\Models\Balita;
use App\Models\Diagnosis;
use App\Models\RekapStunting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class DistribusiBantuanController extends Controller
{
    public function index()
{
    // Ambil semua data rekap stunting dengan status Stunting
    $allStunting = RekapStunting::with('balita')
        ->where(function ($query) {
            $query->where('status_stunting', 'like', '%Stunting Berat%')
                  ->orWhere('status_stunting', 'like', '%Stunting Ringan%');
        })
        ->orderByDesc('tanggal') // Urutkan dari yang terbaru
        ->get();

    // Kelompokkan berdasarkan nama balita dan ambil rekap terbaru
    $stuntingData = $allStunting->unique(function ($item) {
        return $item->balita->nama; // Kelompok berdasarkan nama
    });

    // Kirim ke view
    return view('distribusi_bantuan.index', compact('stuntingData'));
}



 public function show($id)
{
    \Carbon\Carbon::setLocale('id');

    // Ambil diagnosis dan balita
    $diagnosis = RekapStunting::with('balita')->findOrFail($id);

    // Ambil distribusi bantuan berdasarkan diagnosis
    $distribusiBantuan = DistribusiBantuan::with('datastunting.balita')
        ->where('diagnosis_id', $id)
        ->latest('tanggal_distribusi')
        ->get();

    // Ambil rekap stunting terbaru untuk balita (jika ingin ditampilkan)
    $rekapStuntingTerbaru = RekapStunting::where('balita_id', $diagnosis->balita_id)
        ->latest('tanggal')
        ->first();

    return view('distribusi_bantuan.show', compact('diagnosis', 'distribusiBantuan', 'rekapStuntingTerbaru'));
}



    public function create($id)
    {
        // Ambil data diagnosis berdasarkan id
        $diagnosis = RekapStunting::with('balita')->findOrFail($id); 
    
        // Kirim data diagnosis dan balita terkait ke view
        return view('distribusi_bantuan.create', compact('diagnosis'));
    }

    public function store(Request $request)
{
    $request->validate([
        'diagnosis_id' => 'required|exists:rekap_stunting,id', // disesuaikan ke rekap_stunting
        'tanggal_distribusi' => 'required|date',
        'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'keterangan' => 'required|string',
    ]);

    // Ambil data diagnosis (rekap stunting)
    $rekap = RekapStunting::findOrFail($request->diagnosis_id);

    // Simpan file foto bukti
    $path = $request->file('foto_bukti')->store('bukti_distribusi', 'public');

    // Simpan data distribusi bantuan
    DistribusiBantuan::create([
        'diagnosis_id' => $rekap->id, // Ini tetap diagnosis_id meskipun dari tabel rekap_stunting
        'balita_id' => $rekap->balita_id,
        'tanggal_distribusi' => $request->tanggal_distribusi,
        'foto_bukti' => $path,
        'keterangan' => $request->keterangan,
        'user_id' => Auth::id(),
    ]);

    return redirect()
        ->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $rekap->id])
        ->with('success', 'Distribusi bantuan berhasil ditambahkan.');
}

    public function edit($id)
    {
        // Ambil data distribusi bantuan berdasarkan ID, termasuk relasi diagnosis dan balita
        $distribusi = DistribusiBantuan::with(['datastunting.balita'])->findOrFail($id);
    
        return view('distribusi_bantuan.update', compact('distribusi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_distribusi' => 'required|date',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string',
        ]);

        $distribusi = DistribusiBantuan::findOrFail($id);

        // Jika ada file baru diupload, simpan yang baru
        if ($request->hasFile('foto_bukti')) {
            // Hapus file lama jika perlu
            if ($distribusi->foto_bukti && \Storage::disk('public')->exists($distribusi->foto_bukti)) {
                \Storage::disk('public')->delete($distribusi->foto_bukti);
            }

            $path = $request->file('foto_bukti')->store('bukti_distribusi', 'public');
            $distribusi->foto_bukti = $path;
        }

        $distribusi->tanggal_distribusi = $request->tanggal_distribusi;
        $distribusi->keterangan = $request->keterangan;
        $distribusi->save();

        return redirect()->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $request->diagnosis_id])
            ->with('success', 'Data distribusi bantuan berhasil diperbarui.');
    }

    
    



    public function destroy($id)
    {
        $bantuan = DistribusiBantuan::findOrFail($id);
    
        // Hapus file bukti jika ada
        if ($bantuan->foto_bukti && \Storage::exists('public/' . $bantuan->foto_bukti)) {
            \Storage::delete('public/' . $bantuan->foto_bukti);
        }
    
        // Ambil diagnosis_id yang berisi id rekap stunting
        $rekapStuntingId = $bantuan->diagnosis_id;
    
        // Hapus distribusi bantuan
        $bantuan->delete();
    
        // Redirect ke halaman show berdasarkan rekap stunting id (diagnosis_id)
        return redirect()->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $rekapStuntingId])
                         ->with('success', 'Data distribusi bantuan berhasil dihapus.');
    }
    




    
    

}

    

    
    




