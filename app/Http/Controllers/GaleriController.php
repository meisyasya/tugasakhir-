<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\CategoryGaleri;
use App\Http\Requests\StoreGaleriRequest;
use App\Http\Requests\UpdateGaleriRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryGaleri::latest()->get();
        $galeris = Galeri::all();
        return view('LandingPage.galeri.index', compact('categories','galeris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Fetch all categories from the database
         $categories = CategoryGaleri::all();
         // Return the view and pass the categories variable
         return view('LandingPage.galeri.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGaleriRequest $request)
    {
        $data = $request->validated();
    
        // Pastikan title ada sebelum membuat slug
        if (!isset($data['title']) || empty($data['title'])) {
            return redirect()->route('admin.CategoryGaleriCreate')->withErrors(['title' => 'Title is required']);
        }
    
        // Generate slug
        $data['slug'] = Str::slug($data['title']);
    
        // Simpan gambar jika ada
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/galeri', $filename, 'public'); // Simpan ke storage/app/public/images/menumakanan
            $data['img'] = 'images/galeri/' . $filename; // Simpan path relatif di database
        }
    
        Galeri::create($data);
    
        return redirect()->route('admin.CategoryGaleriIndex')->with('success', 'Galeri berhasil dibuat.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGaleriRequest $request, $id)
    {
        $menu = Galeri::findOrFail($id);
    
        // Ambil semua data yang divalidasi
        $data = $request->validated();
    
        // Jika slug tidak diisi, buat dari title
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
    
        // Jika ada gambar baru di-upload
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($menu->img && Storage::exists($menu->img)) {
                Storage::delete($menu->img);
            }
    
            // Simpan gambar baru
            $data['img'] = $request->file('img')->store('menu_images');
        }
    
        // Update data
        $menu->update($data);
    
        return redirect()->route('admin.CategoryGaleriIndex')->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Galeri::findOrFail($id); // akan throw 404 jika data tidak ditemukan
        $menu->delete();
    
        return redirect()->route('admin.CategoryGaleriIndex')->with('success', 'Data berhasil dihapus');
    }
}
