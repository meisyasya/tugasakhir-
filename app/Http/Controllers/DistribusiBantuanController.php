<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DistribusiBantuan;
use App\Models\Balita;
use App\Models\Diagnosis;
use App\Models\RekapStunting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



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


    // Ambil distribusi bantuan berdasarkan diagnosis_id
    $distribusiBantuan = DistribusiBantuan::with('user', 'balita')
        ->where('rekap_stunting_id', $id)
        ->latest('tanggal_distribusi')
        ->get();

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
            'rekap_stunting_id' => 'required|exists:rekap_stunting,id',
            'tanggal_distribusi' => 'required|date',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string',
        ]);
    
        // Ambil data diagnosis (rekap stunting)
        $rekap = RekapStunting::findOrFail($request->rekap_stunting_id); // Ganti diagnosis_id jadi rekap_stunting_id
    
        // Simpan file foto bukti
        $path = $request->file('foto_bukti')->store('bukti_distribusi', 'public');
    
        // Simpan data distribusi bantuan
        DistribusiBantuan::create([
            'rekap_stunting_id' => $rekap->id, // Sesuai nama kolom di tabel distribusi_bantuans
            'balita_id' => $rekap->balita_id,
            'tanggal_distribusi' => $request->tanggal_distribusi,
            'foto_bukti' => $path,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);
    
        if (auth()->user()->hasRole('admin')) {
            return redirect()
            ->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $rekap->id])
            ->with('success', 'Distribusi bantuan berhasil ditambahkan.');   
         } elseif (auth()->user()->hasRole('kader')) {
            return redirect()
            ->route('kader.DistribusiBantuanShow', ['distribusi_bantuan' => $rekap->id])
            ->with('success', 'Distribusi bantuan berhasil ditambahkan.');
    
        }
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

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $distribusi->rekap_stunting_id])
        ->with('success', 'Data distribusi bantuan berhasil diperbarui.');
    } elseif (auth()->user()->hasRole('kader')) {
        return redirect()->route('kader.DistribusiBantuanShow', ['distribusi_bantuan' => $distribusi->rekap_stunting_id])
        ->with('success', 'Data distribusi bantuan berhasil diperbarui.');
    }
}


    
    



    public function destroy($id)
    {
        $bantuan = DistribusiBantuan::findOrFail($id);
    
        // Ambil rekap_stunting_id sebelum dihapus untuk redirect
        $rekapStuntingId = $bantuan->rekap_stunting_id;
    
        // Hapus file foto bukti jika ada
        if ($bantuan->foto_bukti && \Storage::disk('public')->exists($bantuan->foto_bukti)) {
            \Storage::disk('public')->delete($bantuan->foto_bukti);
        }
    
        // Hapus data distribusi bantuan
        $bantuan->delete();
    
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.DistribusiBantuanShow', ['distribusi_bantuan' => $rekapStuntingId])
                         ->with('success', 'Data distribusi bantuan berhasil dihapus.');  
         } elseif (auth()->user()->hasRole('kader')) {
            return redirect()->route('kader.DistribusiBantuanShow', ['distribusi_bantuan' => $rekapStuntingId])
            ->with('success', 'Data distribusi bantuan berhasil dihapus.');  
    
        }
        // Redirect ke halaman show dengan parameter rekap_stunting_id yang benar
       
    }
    

    public function cetakLaporan($id)
    {
        Carbon::setLocale('id'); // Set locale Carbon ke Bahasa Indonesia

        // --- LANGKAH DEBUGGING 1: Pastikan RekapStunting ditemukan ---
        try {
            $diagnosis = RekapStunting::with('balita')->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika RekapStunting tidak ditemukan, redirect atau tampilkan error
            return redirect()->back()->with('error', 'Data rekap stunting tidak ditemukan untuk ID ini.');
        }

        // --- LANGKAH DEBUGGING 2: Pastikan data balita ada di relasi ---
        if (!$diagnosis->balita) {
            return redirect()->back()->with('error', 'Data balita tidak terkait dengan rekap stunting ini.');
        }

        // 2. Ambil semua data Distribusi Bantuan yang terkait dengan Rekap Stunting ini
        $distribusiBantuan = DistribusiBantuan::with('user') // Memuat relasi user (kader)
            ->where('rekap_stunting_id', $id)
            ->latest('tanggal_distribusi') // Urutkan dari yang terbaru
            ->get();

        // --- LANGKAH DEBUGGING 3: Periksa isi data sebelum dikirim ke view ---
        // Uncomment baris di bawah ini untuk melihat data di browser sebelum PDF dibuat
        /*
        $debugData = (object) [
            'balita' => (object) [
                'nama' => $diagnosis->balita->nama ?? 'N/A',
                'nik' => $diagnosis->balita->nik ?? 'N/A',
                'tanggal_lahir' => $diagnosis->balita->tanggal_lahir ?? 'N/A',
                'jenis_kelamin' => $diagnosis->balita->jenis_kelamin ?? 'N/A',
                'nama_ibu' => $diagnosis->balita->nama_ibu ?? 'N/A',
                'alamat' => $diagnosis->balita->alamat ?? 'N/A',
            ],
            'diagnosis' => (object) [
                'tanggal_diagnosis' => $diagnosis->tanggal ?? 'N/A',
                'usia' => $diagnosis->usia ?? 'N/A',
                'berat_badan' => ($diagnosis->berat_badan ?? 'N/A') . ' Kg',
                'tinggi_badan' => ($diagnosis->tinggi_badan ?? 'N/A') . ' cm',
                'imt' => $diagnosis->imt ?? 'N/A',
                'status_gizi' => $diagnosis->status_gizi ?? 'N/A',
                'status_stunting' => $diagnosis->status_stunting ?? 'N/A',
            ],
            'distribusipmt' => $distribusiBantuan->map(function ($item) {
                return (object) [
                    'tanggal_distribusi' => $item->tanggal_distribusi,
                    'foto_bukti' => $item->foto_bukti,
                    'keterangan' => $item->keterangan,
                    'nama_kader' => $item->user->name ?? 'N/A',
                ];
            })->toArray(),
        ];
        dd($debugData); // Ini akan menghentikan eksekusi dan menampilkan data
        */
        // --- AKHIR LANGKAH DEBUGGING 3 ---


        // 3. Siapkan data dalam format yang diharapkan oleh blade PDF
        $laporanData = (object) [
            'balita' => (object) [
                'nama' => $diagnosis->balita->nama,
                'nik' => $diagnosis->balita->nik,
                'tanggal_lahir' => $diagnosis->balita->tanggal_lahir,
                'jenis_kelamin' => $diagnosis->balita->jenis_kelamin,
                'nama_ibu' => $diagnosis->balita->nama_ibu,
                'alamat_lengkap' => $diagnosis->balita->alamat_lengkap,
            ],
            
            'distribusipmt' => $distribusiBantuan->map(function ($item) {
                return (object) [
                    'tanggal_distribusi' => $item->tanggal_distribusi,
                    'foto_bukti' => $item->foto_bukti,
                    'keterangan' => $item->keterangan,
                    'nama_kader' => $item->user->name ?? 'N/A',
                ];
            })->toArray(),
        ];
        
        // 4. Load view untuk template PDF
        // PASTIKAN PATH VIEW INI SESUAI DENGAN LOKASI FILE laporan_pdf.blade.php ANDA
        // Jika file ada di 'resources/views/distribusi_bantuan/laporan_pdf.blade.php', gunakan 'distribusi_bantuan.laporan_pdf'
        // Jika file ada di 'resources/views/admin/distribusi_bantuan/laporan_pdf.blade.php', gunakan 'admin.distribusi_bantuan.laporan_pdf'
        $pdf = PDF::loadView('distribusi_bantuan.laporan_pdf', compact('laporanData'))
          ->setPaper('a4', 'portrait'); // portrait = vertikal, bisa diganti jadi 'landscape' kalau horizontal


        // 5. Konfigurasi dan Kembalikan PDF untuk PREVIEW di browser
        return $pdf->stream('laporan_pmt_stunting_' . $diagnosis->balita->nama . '_' . $diagnosis->id . '.pdf');
    }
    
    

    




    
    

}

    

    
    




