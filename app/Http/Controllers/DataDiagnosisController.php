<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Diagnosis;
use App\Models\RekapBulanan;
use App\Models\RekapStunting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\BalitaGrowthService; 


class DataDiagnosisController extends Controller
{

    protected $balitaGrowthService; // Deklarasi properti untuk service

    // Constructor untuk menginjeksikan BalitaGrowthService
    public function __construct(BalitaGrowthService $balitaGrowthService)
    {
        $this->balitaGrowthService = $balitaGrowthService;
    }

    public function index()
    {
        $diagnoses = Diagnosis::with('balita')->get();
        return view('datadiagnosis.index', compact('diagnoses'));
    }

    public function destroy($id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->delete();
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.DataDiagnosisIndex')->with('success', 'Data diagnosis berhasil dihapus.');
        } elseif (auth()->user()->hasRole('kader')) {
            return redirect()->route('kader.DataDiagnosisIndex')->with('success', 'Data diagnosis berhasil dihapus.');
        }
    }

    public function create()
    {
        $balitas = Balita::with('diagnoses')->get();
        return view('datadiagnosis.creatediagnosis', compact('balitas'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|exists:balitas,id',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'required|numeric|min:0',
            'tanggal_pencatatan' => 'required|date',
        ]);

        $balita = Balita::findOrFail($request->nama);
        // $usia = now()->diffInMonths($balita->tanggal_lahir);
        $tanggalPencatatan = Carbon::parse($request->tanggal_pencatatan);
        $usia = $tanggalPencatatan->diffInMonths($balita->tanggal_lahir);

        $jenisKelaminUntukService = strtoupper(substr($balita->jenis_kelamin, 0, 1));

        $berat_badan = $request->berat_badan;
        $tinggi_badan_cm = $request->tinggi_badan;
        $tinggi_badan_m = $tinggi_badan_cm / 100;
        $imt = $berat_badan / ($tinggi_badan_m * $tinggi_badan_m);
        $lingkar_kepala = $request->lingkar_kepala;

        // **PENTING: Gunakan cekGiziIMT untuk status gizi yang akan disimpan**
        $status_gizi_imt = $this->balitaGrowthService->cekGiziIMT(
            round($imt, 2), // Pastikan IMT yang dihitung dibulatkan sebelum diteruskan
            $usia,
            $jenisKelaminUntukService
        );

        // Jika Anda masih ingin menyimpan hasil BB/U, Anda bisa menggunakan variabel terpisah
        // $status_gizi_bbu = $this->balitaGrowthService->hitungStatusGizi(
        //     $berat_badan,
        //     $usia,
        //     $jenisKelaminUntukService
        // );

        $status_stunting = $this->balitaGrowthService->cekStunting(
            $tinggi_badan_cm,
            $usia,
            $jenisKelaminUntukService
        );

        $diagnosis = Diagnosis::create([
            'balita_id' => $request->nama,
            'tanggal_diagnosis' => $request->tanggal_pencatatan,
            'usia' => $usia,
            'bb' => $berat_badan,
            'tb' => $tinggi_badan_cm,
            'imt' => round($imt, 2),
            'lingkar_kepala' => $lingkar_kepala,
            'status_gizi' => $status_gizi_imt, // Simpan hasil IMT/U
            'hasil_diagnosis' => $status_stunting,
        ]);

        $standarTB = $this->balitaGrowthService->getStandarTinggiBadan($usia, $jenisKelaminUntukService);
        // Panggil getStandarIMT dengan parameter usia dan jenis kelamin
        $standarIMT = $this->balitaGrowthService->getStandarIMT($usia, $jenisKelaminUntukService);

        return view('datadiagnosis.hasildiagnosis', compact('balita', 'diagnosis', 'standarTB', 'standarIMT'))
            ->with('success', 'Diagnosis berhasil disimpan.')
            ->with('diagnosis_id_for_wa', $diagnosis->id);
    }

    // Fungsi yang dipanggil saat klik tombol kirim WA
    public function kirimPesanWA(Request $request, $diagnosisId)
    {
        // Validasi input dari form (ini lebih untuk data yang mungkin di-override dari form)
        $request->validate([
            'hasil_diagnosis' => 'required|string',
            'tb' => 'required|numeric',
            'nama' => 'required|string',
            'nik' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'jenis_kelamin_balita' => 'nullable|string',
            'usia_balita' => 'nullable|numeric',
            'bb_balita' => 'nullable|numeric',
            'imt_balita' => 'nullable|numeric',
            'status_gizi' => 'nullable|string',
            'lingkar_kepala_balita' => 'nullable|numeric', // Validasi untuk lingkar kepala dari form
        ]);

        // 1. Ambil objek diagnosis spesifik berdasarkan $diagnosisId
        $diagnosis = Diagnosis::with('balita.user')->findOrFail($diagnosisId);
        $balita = $diagnosis->balita;

        // 2. Ambil nomor HP wali balita
        $noHp = optional(optional($balita)->user)->phone;

        if (!$noHp) {
            return back()->with('error', 'Nomor HP wali balita tidak ditemukan atau tidak valid.');
        }

        $noHp = preg_replace('/[^0-9]/', '', $noHp);
        $noHp = '62' . ltrim($noHp, '0');

        if (!preg_match('/^62[0-9]{9,13}$/', $noHp)) {
            return back()->with('error', 'Format nomor HP tidak valid untuk WhatsApp.');
        }

        // --- Ambil data dari objek Balita dan Diagnosis ---
        $nikBalita = optional($balita)->nik;
        $namaBalitaFinal = optional($balita)->nama;
        $namaIbuFinal = optional($balita)->nama_ibu;
        $jenisKelaminFinal = optional($balita)->jenis_kelamin;

        // Data dari diagnosis SPESIFIK
        $usiaBalitaDiagnosis = optional($diagnosis)->usia;
        $bbBalitaDiagnosis = optional($diagnosis)->bb;
        $tbBalitaDiagnosis = optional($diagnosis)->tb;
        $imtBalitaDiagnosis = optional($diagnosis)->imt;
        $statusGiziDiagnosis = optional($diagnosis)->status_gizi;
        $hasilDiagnosisDiagnosis = optional($diagnosis)->hasil_diagnosis;
        // Ambil lingkar kepala dari diagnosis
        $lingkarKepalaDiagnosis = optional($diagnosis)->lingkar_kepala;


        // --- Data dari input form saat ini (jika ada override) ---
        $hasilDiagnosisUntukPesan = $request->input('hasil_diagnosis') ?? $hasilDiagnosisDiagnosis ?? 'Belum terdiagnosis';
        $namaUntukPesan = $request->input('nama') ?? $namaBalitaFinal ?? 'Anak Balita';
        $tbUntukPesan = $request->input('tb') ?? $tbBalitaDiagnosis ?? 'N/A';
        $statusGiziUntukPesan = $request->input('status_gizi') ?? $statusGiziDiagnosis ?? 'Tidak Ditemukan';
        // Lingkar kepala dari form, jika diisi, untuk override atau fallback
        $lingkarKepalaUntukPesan = $request->input('lingkar_kepala_balita') ?? $lingkarKepalaDiagnosis ?? 'N/A';


        $tanggalPesan = now()->format('d F Y');

        $namaPengirim = auth()->user()->name ?? 'Petugas Posyandu';

        // --- Rangkai pesan WhatsApp ---
        if (!empty($namaIbuFinal)) {
            $pesan = "Yth. Ibu *{$namaIbuFinal}* Wali dari Ananda *{$namaUntukPesan}*,\n\n";
        } else {
            $pesan = "Yth. Bapak/Ibu Wali dari Ananda *{$namaUntukPesan}*,\n\n";
        }

        $pesan .= "Dengan hormat,\n\n";
        $pesan .= "Bersama ini, kami memberitahukan hasil posyandu Ananda *{$namaUntukPesan}* yang telah dilaksanakan pada tanggal *{$tanggalPesan}*.\n\n";

        $pesan .= "*Detail Informasi Balita:*\n";
        if ($nikBalita) $pesan .= "🔢 *NIK*: {$nikBalita}\n";
        $pesan .= "👶 *Nama Balita*: {$namaUntukPesan}\n";
        if ($namaIbuFinal) $pesan .= "👩‍🍼 *Nama Ibu*: {$namaIbuFinal}\n";
        $pesan .= "🚻 *Jenis Kelamin*: " . ($jenisKelaminFinal ?? 'N/A') . "\n";

        // Perbaikan untuk Usia:
        if ($usiaBalitaDiagnosis === 0) {
            $pesan .= "🗓️ *Usia*: 0 bulan (atau kurang dari 1 bulan)\n";
        } elseif ($usiaBalitaDiagnosis !== null) {
            $pesan .= "🗓️ *Usia*: {$usiaBalitaDiagnosis} bulan\n";
        } else {
            $pesan .= "🗓️ *Usia*: N/A\n"; // Fallback jika usia null
        }

        if ($bbBalitaDiagnosis !== null) $pesan .= "⚖️ *Berat Badan*: {$bbBalitaDiagnosis} kg\n";
        if ($tbUntukPesan !== 'N/A') $pesan .= "📏 *Tinggi Badan*: {$tbUntukPesan} cm\n";

        // --- BARIS BARU UNTUK LINGKAR KEPALA ---
        if ($lingkarKepalaUntukPesan !== 'N/A') $pesan .= "🪖 *Lingkar Kepala*: {$lingkarKepalaUntukPesan} cm\n"; // Ikon helm untuk lingkar kepala

        if ($imtBalitaDiagnosis !== null) $pesan .= "📊 *IMT*: {$imtBalitaDiagnosis}\n\n";


        $pesan .= "*Hasil Diagnosis:*\n";
        $pesan .= "🌱 *Status Stunting*: {$hasilDiagnosisUntukPesan}\n";
        $pesan .= "🍎 *Status Gizi*: {$statusGiziUntukPesan}\n\n";

        $pesan .= "Tetap penuhi gizi seimbang anak dan untuk langkah-langkah selanjutnya, kami sangat menyarankan Ibu untuk segera berkonsultasi dengan tenaga kesehatan apabila ada keluhan\n\n";
        $pesan .= "Terima kasih telah rutin datang ke posyandu ibu *{$namaIbuFinal}*.\n\n";
        $pesan .= "Hormat kami,\n";
        $pesan .= "{$namaPengirim}\n";
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $noHp,
            'message' => $pesan,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Pesan WhatsApp berhasil dikirim.');
        } else {
            Log::error('Fonnte WA Error', ['response' => $response->body()]);
            return back()->with('error', 'Gagal mengirim pesan WhatsApp. ' . $response->body());
        }
    }

  

    public function accDiagnosis($id)
    {
        $diagnosis = Diagnosis::findOrFail($id);

        // Simpan ke Rekap Bulanan
        RekapBulanan::create([
            'balita_id' => $diagnosis->balita_id,
            'tanggal' => $diagnosis->tanggal_diagnosis,
            'usia' => $diagnosis->usia,
            'bb' => $diagnosis->bb,
            'tb' => $diagnosis->tb,
            'lingkar_kepala' => $diagnosis->lingkar_kepala,
            'imt' => $diagnosis->imt,
            'status_gizi' => $diagnosis->status_gizi,
            'hasil_diagnosis' => $diagnosis->hasil_diagnosis,
        ]);

        // Cek apakah termasuk stunting
        $hasilDiagnosis = strtolower($diagnosis->hasil_diagnosis);
        if (in_array($hasilDiagnosis, ['stunting ringan', 'stunting berat'])) {
            // Cek apakah sudah ada rekap stunting untuk balita ini pada tanggal yang sama
            $existingRekap = RekapStunting::where('balita_id', $diagnosis->balita_id)
                ->whereDate('tanggal', $diagnosis->tanggal_diagnosis)
                ->first();

            if (!$existingRekap) {
                // Simpan data lengkap ke rekap_stunting
                RekapStunting::create([
                    'balita_id' => $diagnosis->balita_id,
                    'tanggal' => $diagnosis->tanggal_diagnosis,
                    'usia' => $diagnosis->usia,
                    'bb' => $diagnosis->bb,
                    'tb' => $diagnosis->tb,
                    'imt' => $diagnosis->imt,
                    'status_gizi' => $diagnosis->status_gizi,
                    'status_stunting' => $diagnosis->hasil_diagnosis,
                ]);
            } else {
                // Update jika status stunting berubah
                $existingRekap->update([
                    'usia' => $diagnosis->usia,
                    'bb' => $diagnosis->bb,
                    'tb' => $diagnosis->tb,
                    'imt' => $diagnosis->imt,
                    'status_stunting' => $diagnosis->hasil_diagnosis,
                    'tanggal' => $diagnosis->tanggal_diagnosis,
                ]);
            }
        }

        // Hapus data diagnosis setelah direkap
        $diagnosis->delete();

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.DataDiagnosisIndex')->with('success', 'Diagnosis berhasil direkap bulanan dan stunting');
        } elseif (auth()->user()->hasRole('kader')) {
            return redirect()->route('kader.DataDiagnosisIndex')->with('success', 'Diagnosis berhasil direkap bulanan dan stunting.');
        }

    }
}