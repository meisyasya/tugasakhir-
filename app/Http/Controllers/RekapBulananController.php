<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapBulanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;;



class RekapBulananController extends Controller 
{

    public function index(Request $request)
{
    // Mengambil nilai input 'search' dari request.
    $search = $request->input('search');

    // Menginisialisasi query builder untuk model RekapBulanan.
    $rekapsQuery = RekapBulanan::with('balita')
        // Metode `when()` hanya akan menjalankan callback jika kondisi pertama (yaitu $search ada dan tidak kosong) adalah true.
        ->when($search, function ($query, $search) {
            $query->whereHas('balita', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('tanggal', 'desc')
        ->get()
        ->groupBy(function ($item) {
            // Ini berguna untuk tampilan di mana Anda ingin mengelompokkan data per hari.
            return \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y');
        });

    return view('rekap_bulanan.index', [
        'rekaps' => $rekapsQuery,
        'search' => $search
    ]);
}


    public function show($id)
    {
        $rekap = RekapBulanan::with('balita')->findOrFail($id);
        return view('rekap_bulanan.show', compact('rekap'));
    }


    public function print($tanggal)
    {
        // mengubah format tanggal
        $parsedTanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
    
        $rekaps = \App\Models\RekapBulanan::with('balita')
            ->whereDate('tanggal', $parsedTanggal)
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('rekap_bulanan.print', compact('rekaps', 'tanggal'))
            ->setPaper('A4', 'landscape');
    
        return $pdf->stream("Rekap-Absensi-{$tanggal}.pdf");
    }
    
    

}
