<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RekapBulanan;
use App\Models\Balita;
use App\Services\ChildGrowthService;
use App\Models\Rekomendasi;


class RekapPertumbuhanController extends Controller
{
    protected ChildGrowthService $childGrowthService;

    public function __construct(ChildGrowthService $childGrowthService)
    {
        $this->childGrowthService = $childGrowthService;
    }

    public function pertumbuhananak()
    {
        $user = Auth::user();

        if ($user->hasRole('ortu')) {
            // Ambil ID semua anak milik ortu ini
            $balitaIds = $user->balitas->pluck('id');

            // Ambil diagnosis hanya untuk anak-anak ortu ini
            $diagnoses = RekapBulanan::whereIn('balita_id', $balitaIds)->with('balita')->get();
        } else {
            // Jika bukan ortu (misalnya admin/petugas), tampilkan semua
            $diagnoses = RekapBulanan::with('balita')->get();
        }

        // Ambil semua data rekomendasi dan key-kan berdasarkan 'jenis_stunting'
        // Ini akan memudahkan pencarian rekomendasi di view
        $rekomendasis = Rekomendasi::all()->keyBy('jenis_stunting');

        // Kirim data diagnosis dan rekomendasi ke view
        return view('datadiagnosis.rekap_pertumbuhan_anak', compact('diagnoses', 'rekomendasis'));
    }

  // Metode BARU untuk menampilkan Grafik Gizi (Berat Badan per Usia - BB/U)
public function showGrafikGizi($balitaId)
{
    $balita = Balita::findOrFail($balitaId);

    $rekapData = RekapBulanan::where('balita_id', $balitaId)
                            ->whereNotNull('bb') // Hanya ambil data yang ada berat badannya
                            ->orderBy('usia')
                            ->get();

    $jenisKelaminChar = ($balita->jenis_kelamin === 'Laki-laki' ? 'L' : 'P');

    // Mengambil standar BB/U dari service
    $selectedWhoStandardWeight = $this->childGrowthService->getWeightForAgeStandards($jenisKelaminChar); // <--- Ubah nama variabel di sini

    // Tambahkan perhitungan status gizi BB/U untuk setiap rekap data
    foreach ($rekapData as $data) {
        $growthStatus = $this->childGrowthService->getGrowthStatusWeightForAge(
            $data->usia,
            $data->bb, // Menggunakan berat badan
            $jenisKelaminChar
        );
        // Ini untuk status BB/U yang akan ditampilkan di tabel data pengukuran balita
        $data->calculated_status_gizi_bb_u = $growthStatus['status']; // <--- Tambahkan properti ini
        $data->calculated_diagnosis_description = $growthStatus['description']; // Ini mungkin lebih ke deskripsi gizi BB/U, bukan diagnosis stunting
    }

    // Ini akan mengarahkan ke view baru khusus untuk grafik BB/U
    return view('datadiagnosis.rekap_grafik_gizi', compact('balita', 'rekapData', 'selectedWhoStandardWeight', 'jenisKelaminChar')); // <--- Kirim dengan nama yang benar
}


public function showGrafikStunting($balitaId)
{
    $balita = Balita::findOrFail($balitaId);

    $rekapData = RekapBulanan::where('balita_id', $balitaId)
                            ->orderBy('usia')
                            ->get();

    $jenisKelaminChar = ($balita->jenis_kelamin === 'Laki-laki' ? 'L' : 'P');

    // Mengambil standar TB/U dari service
    $selectedWhoStandardHeight = $this->childGrowthService->getHeightForAgeStandards($jenisKelaminChar);

    // Tambahkan perhitungan status gizi untuk setiap rekap data (TB/U)
    foreach ($rekapData as $data) {
        $growthStatusTbU = $this->childGrowthService->getGrowthStatusHeightForAge(
            $data->usia,
            $data->tb,
            $jenisKelaminChar
        );
        $data->calculated_status_gizi = $growthStatusTbU['status']; // Ini untuk TB/U
        $data->calculated_diagnosis_description = $growthStatusTbU['description'];

        // Bagian perhitungan status gizi untuk BB/U dihapus
    }

    // Kirim semua variabel yang dibutuhkan ke view
    return view('datadiagnosis.rekap_grafik', compact(
        'balita',
        'rekapData',
        'selectedWhoStandardHeight',
        'jenisKelaminChar'
        // 'selectedWhoStandardWeight' dihapus karena tidak lagi digunakan
    ));
}

  



    

   
}
