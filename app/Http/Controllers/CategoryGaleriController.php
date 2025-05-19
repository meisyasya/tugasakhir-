<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryGaleri;
use App\Models\Galeri;
use App\Http\Requests\StoreCategoryGaleriRequest;
use Illuminate\Support\Str;

class CategoryGaleriController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryGaleriRequest $request)
    {
        // Validasi sudah ditangani oleh StoreCategoryMakananRequest

        // Cek apakah nama kategori sudah ada
        if (CategoryGaleri::where('name', $request->name)->exists()) {
            // Kembalikan dengan pesan error jika nama sudah ada
            return back()->withErrors(['name' => 'Nama kategori sudah ada, silakan pilih nama lain.'])->withInput();
        }

        // Buat slug dan simpan data
        $data = $request->validated(); // Ambil data yang sudah divalidasi
        $data['slug'] = Str::slug($data['name']);
        
        CategoryGaleri::create($data);

        return back()->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|min:3'
        ]);
        $data['slug'] = Str::slug($data['name']);

        CategoryGaleri::find($id)->update($data);
        return back()->with('success','Categories berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CategoryGaleri::find($id)->delete();
        return back()->with('success','Categories berhasil di delete');
    }
}
