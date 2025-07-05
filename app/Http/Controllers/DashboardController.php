<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Balita;
use App\Models\RekapStunting; // Pastikan ini diimpor dengan benar
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\JadwalPosyandu;
use App\Models\RekapBulanan;
use Illuminate\Support\Facades\Auth;
use App\Services\ChildGrowthService;

class DashboardController extends Controller
{

    // 1. Declare the property
    protected ChildGrowthService $childGrowthService;

    // 2. Implement the constructor for dependency injection
    public function __construct(ChildGrowthService $childGrowthService)
    {
        $this->childGrowthService = $childGrowthService;
    }

    public function index()
    {
        // --- Data for Card Admin (statistik keseluruhan) ---
        $total_user = User::count();
        $total_balita = Balita::count();

        // Jumlah Anak Stunting
        $total_stunting = RekapStunting::whereIn('status_stunting', ['Stunting', 'Sangat Stunting', 'Stunting Ringan', 'Stunting Berat'])
                                         ->distinct('balita_id')
                                         ->count();

        // --- Data untuk Kartu Ibu yang Sedang Login ---
        $namaIbu = null;
        $totalBalitaIbu = 0;
        $balitaPertama = null;
        $rekapDataOrtu = [];
        $selectedWhoStandardHeightOrtu = [];

        $ibu = Auth::user();

        if ($ibu) {
            $namaIbu = $ibu->name;
            $totalBalitaIbu = $ibu->balitas->count();

            // --- Logika untuk Grafik TB/U Balita Orang Tua ---
            $balitaPertama = $ibu->balitas()->first();

            if ($balitaPertama) {
                $rekapData = RekapBulanan::where('balita_id', $balitaPertama->id)
                                        ->whereNotNull('tb')
                                        ->orderBy('usia', 'asc')
                                        ->get();

                $rekapDataOrtu = $rekapData->map(function ($item) {
                    return [
                        'usia' => $item->usia,
                        'tb' => $item->tb,
                    ];
                });

                $jenisKelaminChar = ($balitaPertama->jenis_kelamin === 'Laki-laki' ? 'L' : 'P');

                // <--- This is where you use the injected service
                $selectedWhoStandardHeightOrtu = $this->childGrowthService->getHeightForAgeStandards($jenisKelaminChar);
            }
        }

        // --- Data untuk Grafik Bulanan ---
        $months = [];
        $balitaCounts = [];
        $stuntingCounts = [];

        $startMonth = Carbon::create(2025, 1, 1);
        $currentMonth = Carbon::now();

        while ($startMonth->lte($currentMonth)) {
            $monthName = $startMonth->translatedFormat('M Y');
            $months[] = $monthName;

            $balitasInMonth = Balita::whereMonth('created_at', $startMonth->month)
                                         ->whereYear('created_at', $startMonth->year)
                                         ->count();
            $balitaCounts[] = $balitasInMonth;

            $stuntingsInMonth = RekapStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Berat', 'Stunting', 'Sangat Stunting'])
                                              ->whereMonth('tanggal', $startMonth->month)
                                              ->whereYear('tanggal', $startMonth->year)
                                              ->distinct('balita_id')
                                              ->count();
            $stuntingCounts[] = $stuntingsInMonth;

            $startMonth->addMonth();
        }

        // --- Data untuk Jadwal Posyandu Terdekat ---
        $jadwalPosyanduTerdekat = JadwalPosyandu::where('tanggal', '>=', Carbon::now()->startOfDay())
                                                 ->orderBy('tanggal', 'asc')
                                                 ->first();

        $namaJadwalTerdekat = 'Belum Ada Jadwal';
        $tanggalJadwalTerdekat = '';
        $lokasiJadwalTerdekat = '';

        if ($jadwalPosyanduTerdekat) {
            $namaJadwalTerdekat = $jadwalPosyanduTerdekat->nama_kegiatan;
            $tanggalJadwalTerdekat = Carbon::parse($jadwalPosyanduTerdekat->tanggal)->translatedFormat('d F Y');
            $lokasiJadwalTerdekat = $jadwalPosyanduTerdekat->lokasi;
        }

        // Kembalikan view dengan semua data yang diperlukan
        return view('dashboard', compact(
            'total_user',
            'total_balita',
            'total_stunting',
            'namaIbu',
            'totalBalitaIbu',
            'balitaPertama',
            'rekapDataOrtu',
            'selectedWhoStandardHeightOrtu',
            'months',
            'balitaCounts',
            'stuntingCounts',
            'namaJadwalTerdekat',
            'tanggalJadwalTerdekat',
            'lokasiJadwalTerdekat'
        ));
    }


    public function index2()
    {
        // --- Data untuk Card ---
        $total_user = User::count();
        $total_balita = Balita::count();

        // Jumlah Anak Stunting: Ambil dari RekapStunting dengan status_stunting tertentu
        // Menghitung balita unik yang pernah tercatat stunting sepanjang waktu
        $total_stunting = RekapStunting::whereIn('status_stunting', ['Stunting', 'Sangat Stunting', 'Stunting Ringan', 'Stunting Berat'])
                                         ->distinct('balita_id')
                                         ->count();

        // --- Data untuk Grafik Bulanan ---
        $months = [];
        $balitaCounts = [];
        $stuntingCounts = [];

        // Tentukan bulan awal grafik (Januari 2025)
        $startMonth = Carbon::create(2025, 1, 1)->startOfMonth(); // Pastikan di awal bulan

        // Cari bulan terakhir di mana ada data di tabel Balita dan RekapStunting
        $latestBalitaDate = Balita::max('created_at');
        $latestStuntingDate = RekapStunting::max('tanggal');

        // Tentukan bulan terakhir yang akan ditampilkan di grafik
        // Inisialisasi dengan bulan awal grafik jika tidak ada data sama sekali
        $endMonthForChart = $startMonth->copy(); // Default: bulan awal grafik

        // Periksa data terbaru dari Balita
        if ($latestBalitaDate) {
            $balitaMaxMonth = Carbon::parse($latestBalitaDate)->startOfMonth();
            if ($balitaMaxMonth->greaterThan($endMonthForChart)) {
                $endMonthForChart = $balitaMaxMonth;
            }
        }

        // Periksa data terbaru dari RekapStunting
        if ($latestStuntingDate) {
            $stuntingMaxMonth = Carbon::parse($latestStuntingDate)->startOfMonth();
            if ($stuntingMaxMonth->greaterThan($endMonthForChart)) {
                $endMonthForChart = $stuntingMaxMonth;
            }
        }

        // Jika setelah semua pengecekan, endMonthForChart masih sama dengan startMonth
        // (artinya tidak ada data sama sekali atau hanya ada data di bulan awal)
        // Maka kita bisa mempertimbangkan untuk menampilkan minimal sampai bulan saat ini
        // Namun, karena Anda tidak ingin menggunakan now(), kita akan biarkan berdasarkan data saja.
        // Jika Anda ingin minimal sampai bulan saat ini, Anda bisa uncomment baris berikut:
        // if ($endMonthForChart->lessThan(Carbon::now()->startOfMonth())) {
        //     $endMonthForChart = Carbon::now()->startOfMonth();
        // }

        // Tambahkan satu bulan ekstra di akhir untuk visualisasi yang lebih baik
        $endMonthForChart->addMonth();


        // Loop dari bulan awal yang ditentukan hingga bulan akhir yang dihitung
        $loopMonth = $startMonth->copy(); // Gunakan variabel terpisah untuk loop
        while ($loopMonth->lte($endMonthForChart)) {
            $monthName = $loopMonth->translatedFormat('M Y');
            $months[] = $monthName;

            // Jumlah Balita yang Terdaftar per Bulan (berdasarkan created_at)
            $balitasInMonth = Balita::whereMonth('created_at', $loopMonth->month)
                                    ->whereYear('created_at', $loopMonth->year)
                                    ->count();
            $balitaCounts[] = $balitasInMonth;

            // Jumlah Kasus Stunting dari RekapStunting per Bulan (berdasarkan tanggal pencatatan)
            $stuntingsInMonth = RekapStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Berat', 'Stunting', 'Sangat Stunting'])
                                            ->whereMonth('tanggal', $loopMonth->month)
                                            ->whereYear('tanggal', $loopMonth->year)
                                            ->distinct('balita_id') // Menghitung balita unik yang stunting di bulan tersebut
                                            ->count();
            $stuntingCounts[] = $stuntingsInMonth;

            // Maju ke bulan berikutnya
            $loopMonth->addMonth();
        }

        return view('dashboard', compact(
            'total_user',
            'total_balita',
            'total_stunting',
            'months',
            'balitaCounts',
            'stuntingCounts'
        ));
    }

   
}