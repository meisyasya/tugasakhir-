<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balita;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DataBalitaController extends Controller
{
    public function Index()
    {
        $balitas = auth()->user()->balitas; // ambil hanya balita milik user yang login
        return view('Ortu.Balita.index', compact('balitas'));
        
    }
    public function create()
    {
        $user = auth()->user();
        return view('Ortu.Balita.create', compact('user'));
    }
    public function store(Request $request)
    {
       // Validasi request
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:balitas,nik',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date_format:d-m-Y', // format sesuai flatpickr: d-m-Y
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'img' => 'required|image|max:2048', // Max 2MB
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'required|numeric|min:0',
            'nik_ibu' => 'required|numeric|digits:16',
            'nama_ibu' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'posyandu' => 'required|string',
        ]);

        // Konversi tanggal_lahir dari d-m-Y ke Y-m-d dengan pengamanan
        try {
            $tanggalLahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['tanggal_lahir' => 'Format tanggal tidak valid.'])->withInput();
        }
        
        // Ambil semua data kecuali file img
        $data = $request->except('img');
        $data['user_id'] = auth()->id();
        $data['tanggal_lahir'] = $tanggalLahir;

        // Proses upload foto
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = now()->format('YmdHis') . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images/balita', $filename);
            $data['img'] = 'storage/images/balita/' . $filename;
        }

        // Simpan data ke database
        Balita::create($data);

        // Redirect dengan pesan sukses
        return redirect()->route('ortu.DataAnakIndex')->with('success', 'Data Balita berhasil ditambahkan.');

    }
    
    public function show($id)
    {
        // Ambil data anak berdasarkan ID
        $balita = Balita::findOrFail($id);

        // Kirim data ke view detail.blade.php
        return view('Ortu.Balita.show', compact('balita'));
    }

    public function edit($id)
    {
    $balita = Balita::findOrFail($id);
    return view('Ortu.Balita.update', compact('balita'));
    }

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);
    
        // Validasi input dari form
        $request->validate([
            'nik' => 'required|numeric|unique:balitas,nik,' . $id, // Cek NIK unik kecuali data ini sendiri
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date_format:d-m-Y', // Validasi dengan format dd-mm-yy
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'img' => 'nullable|image|max:2048', // Bisa kosong jika tidak mengganti gambar
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'nik_ibu' => 'required|numeric',
            'nama_ibu' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'posyandu' => 'required|string',
        ]);
    
        // Mengambil data kecuali gambar
        $data = $request->except('img');
    
        // Memastikan tanggal lahir disimpan dalam format Y-m-d untuk kompatibilitas database
        $data['tanggal_lahir'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir)->format('Y-m-d');
        
        // Jika ada file baru, hapus gambar lama dan simpan yang baru
        if ($request->hasFile('img')) {
            if ($balita->img) {
                Storage::delete(str_replace('storage/', 'public/', $balita->img)); // Hapus gambar lama
            }
    
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/images/balita', $filename);
            $data['img'] = 'storage/images/balita/' . $filename; // Menyimpan path gambar
        }
    
        // Update data balita di database
        $balita->update($data);
    
        // Redirect dengan pesan sukses
        return redirect()->route('ortu.DataAnakIndex')->with('success', 'Data Balita berhasil diperbarui.');
    }
    
}