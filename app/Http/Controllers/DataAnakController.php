<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 

class DataAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // instance user yang sedang login
        $user = Auth::user(); 

        $balitas = collect(); // Inisialisasi koleksi kosong
        $listPosyandu = collect(); // Inisialisasi koleksi kosong

        if ($user->hasRole('admin')) {
            // Admin bisa filter dan melihat semua posyandu
            $listPosyandu = collect(range(1, 8))->map(function ($i) {
                return "Posyandu Melati $i";
            });

            $query = Balita::query();
            if ($request->filled('posyandu')) {
                $query->where('posyandu', $request->posyandu);
            }
            // Eksekusi query dengan eager loading relasi 'user' (pemilik data balita)
            $balitas = $query->with('user')->get();

        } elseif ($user->hasRole('kader')) {
            // Kader hanya bisa melihat posyandu mereka sendiri
            $listPosyandu = collect([$user->posyandu]); // Pastikan ini array/collection

            // Mengambil data balita yang memiliki `user_id` sama dengan ID user yang sedang login.
            // Melakukan eager loading relasi 'user'.
            $balitas = Balita::where('posyandu', $user->posyandu)
                ->with('user')
                ->get();

        } elseif ($user->hasRole('bidan')) {
            // Bidan melihat semua data balita (atau sesuaikan jika ada batasan area)
            $listPosyandu = collect(range(1, 8))->map(function ($i) {
                return "Posyandu Melati $i";
            });
            $balitas = Balita::with('user')->get();

        } elseif ($user->hasRole('ortu')) { // Tambahkan kondisi untuk peran 'ortu'
            // Orang tua hanya bisa melihat balita yang terkait dengan user_id mereka
            // Filter posyandu tidak relevan untuk ortu karena hanya melihat anaknya sendiri
            $listPosyandu = collect(); // Atau ambil posyandu dari anaknya jika perlu ditampikan
            $balitas = Balita::where('user_id', $user->id)
                ->with('user')
                ->get();

        } else {
            // Jika user tidak memiliki peran yang diizinkan
            abort(403, 'Unauthorized');
        }

        
        return view('DataAnak.index', compact('balitas', 'listPosyandu'));
    }


    

   

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // Mengambil data user dengan role 'ortu'
    //     $users = User::role('ortu')->get(); // Ambil semua user dengan role ortu
    //     return view('DataAnak.create', compact('users'));
    // }



    public function create()
{
    $user = auth()->user();

    // Ambil semua user dengan role 'ortu' (ibu)
    $users = User::role('ortu')->get();

    if ($user->hasRole('admin')) {
        // Admin bisa pilih semua posyandu
        $listPosyandu = [];
        for ($i = 1; $i <= 8; $i++) {
            $listPosyandu[] = "Posyandu Melati $i";
        }
        return view('DataAnak.create', compact('listPosyandu', 'users'));
    } elseif ($user->hasRole('kader')) {
        // Kader hanya dapat posyandu miliknya sendiri
        $posyandu = $user->posyandu ?? null; // pastikan ada kolom posyandu di users table
        return view('DataAnak.create', compact('posyandu', 'users'));
    }

    // Role lain, jika ada
    abort(403, 'Unauthorized');
}




    
    
    public function store(Request $request)
{
    $request->validate([
        'nik' => 'required|numeric|digits:16|unique:balitas,nik',
        'nama' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date_format:d-m-Y',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'img' => 'required|image|max:2048',
        'berat_badan' => 'required|numeric|min:0',
        'tinggi_badan' => 'required|numeric|min:0',
        'lingkar_kepala' => 'required|numeric|min:0',
        'nik_ibu' => 'required|numeric|digits:16',
        'user_id' => 'required|exists:users,id',
        'alamat_lengkap' => 'required|string',
        'rt' => 'required|string|max:3',
        'rw' => 'required|string|max:3',
        'posyandu' => 'required|string',
    ]);

    try {
        $tanggalLahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir)->format('Y-m-d');
    } catch (\Exception $e) {
        return back()->withErrors(['tanggal_lahir' => 'Format tanggal tidak valid.'])->withInput();
    } 

    $data = $request->except('img');
    $data['tanggal_lahir'] = $tanggalLahir;

  // Mencari user berdasarkan user_id yang diterima dari request.
    $user = User::findOrFail($request->user_id);
    $data['nama_ibu'] = $user->name;

    if ($request->hasFile('img')) {
        $file = $request->file('img');
        // Format: TahunBulanHariJamMenitDetik_nama-balita.ekstensi
        $filename = now()->format('YmdHis') . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images/balita', $filename);
        $data['img'] = 'storage/images/balita/' . $filename;
    }
    // Membuat record baru di tabel 'balitas' menggunakan data yang sudah disiapkan.
    Balita::create($data);

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.DataAnakIndex')->with('success', 'Data Balita berhasil ditambahkan oleh Admin.');
    } elseif (auth()->user()->hasRole('kader')) {
        return redirect()->route('kader.DataAnakIndex')->with('success', 'Data Balita berhasil ditambahkan oleh Kader.');
    }

    // Fallback jika tidak ada peran yang cocok (jarang terjadi jika otorisasi sudah di-handle)
    return redirect('/dashboard')->with('success', 'Data Balita berhasil ditambahkan.');
}


    
    /**
     * Display the specified resource.
     */
        public function show($id)
    {
        // Ambil data anak berdasarkan ID
        $balita = Balita::findOrFail($id);

        // Kirim data ke view detail.blade.php
        return view('DataAnak.show', compact('balita'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $balita = Balita::findOrFail($id);
    return view('DataAnak.edit', compact('balita'));
    }
   

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);
    
        $request->validate([
            'nik' => 'required|numeric|unique:balitas,nik,' . $id,
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'img' => 'nullable|image|max:2048',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'nik_ibu' => 'required|numeric',
            'nama_ibu' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'posyandu' => 'required|string',
        ]);
    
        $data = $request->except('img');
    
        // Konversi tanggal ke format Y-m-d
        $data['tanggal_lahir'] = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir)->format('Y-m-d');
    
      // Memeriksa apakah ada file 'img' baru yang diunggah.
        if ($request->hasFile('img')) {
            // apakah ada  img yg diunggah sebelumnya
            if ($balita->img) {
                Storage::delete(str_replace('storage/', 'public/', $balita->img));
            }
    
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/images/balita', $filename);
            $data['img'] = 'storage/images/balita/' . $filename;
        }
    
        $balita->update($data);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.DataAnakIndex')->with('success', 'Data Balita berhasil diperbarui oleh Admin.');
        } elseif (auth()->user()->hasRole('kader')) {
           
            return redirect()->route('kader.DataAnakIndex')->with('success', 'Data Balita berhasil diperbarui oleh Kader.');
        }
    
        // Fallback jika tidak ada peran yang cocok (jarang terjadi jika otorisasi sudah di-handle)
        return redirect('/dashboard')->with('success', 'Data Balita berhasil ditambahkan.');
    
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $balita = Balita::findOrFail($id);

    // Hapus file gambar jika ada
    if ($balita->img && file_exists(public_path($balita->img))) {
        unlink(public_path($balita->img));
    }

    $balita->delete();

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.DataAnakIndex')->with('success', 'Data Balita berhasil dihapus oleh Admin.');
    } elseif (auth()->user()->hasRole('kader')) {
        // Anda perlu menentukan rute untuk kader setelah penghapusan.
        // Misalnya, 'kader.DataAnakIndex' atau rute lain yang relevan.
        return redirect()->route('kader.DataAnakIndex')->with('success', 'Data Balita berhasil dihapus oleh Kader.');
    }

    // Fallback jika tidak ada peran yang cocok atau rute default
    return redirect('/dashboard')->with('success', 'Data Balita berhasil dihapus.');
}



}
