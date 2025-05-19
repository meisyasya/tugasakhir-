<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Diagnosis;
use App\Models\RekapBulanan;
use App\Models\RekapStunting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class DataDiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::with('balita')->get();
        return view('datadiagnosis.index', compact('diagnoses'));
    }

    public function destroy($id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->delete();
        return redirect()->route('admin.DataDiagnosisIndex')->with('success', 'Data diagnosis berhasil dihapus.');
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
        $usia = now()->diffInMonths($balita->tanggal_lahir);

        $jenisKelaminGizi = strtolower($balita->jenis_kelamin) == "laki-laki" ? "male" : "female";
        $jenisKelaminStunting = strtolower($balita->jenis_kelamin) == "laki-laki" ? "L" : "P";

        $berat_badan = $request->berat_badan;
        $tinggi_badan_m = $request->tinggi_badan / 100;
        $imt = $berat_badan / ($tinggi_badan_m * $tinggi_badan_m);

        $status_gizi = $this->hitungStatusGizi($berat_badan, $request->tinggi_badan, $usia, $jenisKelaminGizi);
        $status_stunting = $this->cekStunting($request->tinggi_badan, $usia, $jenisKelaminStunting);

        $diagnosis = Diagnosis::create([
            'balita_id' => $request->nama,
            'tanggal_diagnosis' => $request->tanggal_pencatatan,
            'usia' => $usia,
            'bb' => $berat_badan,
            'tb' => $request->tinggi_badan,
            'imt' => round($imt, 2),
            'status_gizi' => $status_gizi,
            'hasil_diagnosis' => $status_stunting,
        ]);

        // Kirim pesan WhatsApp hanya jika status stunting terdeteksi
       
        
        return view('datadiagnosis.hasildiagnosis', compact('balita', 'diagnosis'));
    }

//     // Kirim WA otomatis via Fonnte
// private function sendWhatsAppMessage($balita, $status_stunting)
// {
//     $token = env('FONNTE_TOKEN');

//     $phoneNumber = optional($balita->user)->phone;

//     if (!$phoneNumber) {
//         \Log::warning('Nomor HP tidak tersedia untuk balita ID ' . $balita->id);
//         return;
//     }

//     // Bersihkan nomor HP dari karakter non-digit
//     $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

//     // Ubah awalan 0 menjadi 62
//     if (substr($phoneNumber, 0, 1) === '0') {
//         $phoneNumber = '62' . substr($phoneNumber, 1);
//     } elseif (substr($phoneNumber, 0, 2) !== '62') {
//         $phoneNumber = '62' . $phoneNumber; // Fallback jika user tidak awali dengan 0
//     }

//     $message = "Peringatan! Hasil diagnosis stunting: *{$status_stunting}* pada balita *{$balita->nama}*.";

//     $response = Http::withHeaders([
//         'Authorization' => $token,
//     ])->post('https://api.fonnte.com/send', [
//         'target' => $phoneNumber,
//         'message' => $message,
//         'countryCode' => '62',
//     ]);

//     if ($response->failed()) {
//         \Log::error('Gagal mengirim pesan WA via Fonnte', [
//             'balita_id' => $balita->id,
//             'response' => $response->body()
//         ]);
//     }
// }



// Fungsi yang dipanggil saat klik tombol kirim WA
public function kirimPesanWA(Request $request, $id)
{
    $balita = \App\Models\Balita::with('user')->findOrFail($id);
    $noHp = optional($balita->user)->phone;

    if (!$noHp) {
        return back()->with('error', 'Nomor HP tidak ditemukan.');
    }

    $noHp = str_replace(['+', ' ', '-'], '', $noHp);
    if (substr($noHp, 0, 1) !== '+') {
        $noHp = '+62' . ltrim($noHp, '0');
    }

    $nama = $request->input('nama');
    $tb = $request->input('tb');
    $hasil = $request->input('hasil_diagnosis');

    $pesan = "*Pemberitahuan Hasil Diagnosis Stunting:*\n\n";
    $pesan .= "👶 Nama Balita: *{$nama}*\n";
    $pesan .= "📏 Tinggi Badan: *{$tb} cm*\n";
    $pesan .= "📊 Hasil: *{$hasil}*\n\n";
    $pesan .= "Silakan konsultasi lebih lanjut dengan tenaga kesehatan.";

    // Kirim via Fonnte API
    $response = Http::withHeaders([
        'Authorization' => env('FONNTE_TOKEN'),
    ])->post('https://api.fonnte.com/send', [
        'target' => $noHp,
        'message' => $pesan,
        'countryCode' => '62',
    ]);

    if ($response->successful()) {
        return back()->with('success', 'Pesan WhatsApp berhasil dikirim.');
    } else {
        return back()->with('error', 'Gagal mengirim pesan WhatsApp.');
    }
}



    public function hitungStatusGizi($beratBadan, $tinggiBadan, $usia, $jenisKelamin)
    {
        $jenisKelamin = strtolower($jenisKelamin);

        $tabel = [
            'male' => [
                12 => [13.5, 14.0, 15.5, 16.5, 17.5, 18.5, 19.5],
                24 => [14.0, 14.5, 16.0, 17.0, 18.0, 19.0, 20.0],
            ],
            'female' => [
                12 => [13.0, 13.5, 15.0, 16.0, 17.0, 18.0, 19.0],
                24 => [13.5, 14.0, 15.5, 16.5, 17.5, 18.5, 19.5],
            ]
        ];

        $usiaTerdekat = 12;
        foreach (array_keys($tabel[$jenisKelamin]) as $u) {
            if ($usia >= $u) {
                $usiaTerdekat = $u;
            }
        }

        $dataIMT = $tabel[$jenisKelamin][$usiaTerdekat];
        list($min3, $min2, $min1, $plus1, $plus2, $plus3) = $dataIMT;

        $imt = $beratBadan / (($tinggiBadan / 100) ** 2);

        if ($imt < $min3) {
            return "Gizi Buruk";
        } elseif ($imt < $min2) {
            return "Gizi Kurang";
        } elseif ($imt < $plus1) {
            return "Gizi Baik";
        } elseif ($imt < $plus2) {
            return "Berisiko Gizi Lebih";
        } elseif ($imt < $plus3) {
            return "Gizi Lebih";
        } else {
            return "Obesitas";
        }
    }

    public function cekStunting($tinggiBadan, $usia, $jenisKelamin)
    {
        $tabel = [
            'L' => [
                0 => [44.2, 46.1],
                1 => [48.9, 50.8],
                2 => [52.4, 54.4],
                60 => [96.1, 100.7]
            ],
            'P' => [
                0 => [43.6, 45.4],
                1 => [47.8, 49.8],
                2 => [51.0, 53.0],
                60 => [96.1, 100.7]
            ]
        ];

        $usiaTerdekat = 0;
        foreach (array_keys($tabel[$jenisKelamin]) as $u) {
            if ($usia >= $u) {
                $usiaTerdekat = $u;
            }
        }

        [$min3SD, $min2SD] = $tabel[$jenisKelamin][$usiaTerdekat];

        if ($tinggiBadan < $min3SD) {
            return "Stunting Berat";
        } elseif ($tinggiBadan < $min2SD) {
            return "Stunting Ringan";
        } else {
            return "Tidak Stunting";
        }
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
    
        return view('datadiagnosis.rekap_pertumbuhan_anak', compact('diagnoses'));
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

    return redirect()->route('bidan.DataDiagnosisIndex')->with('success', 'Diagnosis berhasil direkap bulanan dan stunting');
}


}
