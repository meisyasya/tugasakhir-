<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapBulanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RekapBulananController extends Controller
{

    public function index()
    {
        $rekaps = RekapBulanan::with('balita')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('d-m-Y');
            });

        return view('rekap_bulanan.index', compact('rekaps'));
    }

}
