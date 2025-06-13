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
    $search = $request->input('search');

    $rekapsQuery = RekapBulanan::with('balita')
        ->when($search, function ($query, $search) {
            $query->whereHas('balita', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('tanggal', 'desc')
        ->get()
        ->groupBy(function ($item) {
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
        $parsedTanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
    
        $rekaps = \App\Models\RekapBulanan::with('balita')
            ->whereDate('tanggal', $parsedTanggal)
            ->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('rekap_bulanan.print', compact('rekaps', 'tanggal'))
            ->setPaper('A4', 'landscape');
    
        return $pdf->stream("Rekap-Absensi-{$tanggal}.pdf");
    }
    
    

}
