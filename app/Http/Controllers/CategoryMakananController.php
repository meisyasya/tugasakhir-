<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryMakananRequest;
use App\Http\Requests\StoreMenuMakananRequest;
use App\Models\CategoryMakanan;
use App\Models\MenuMakanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $categories = CategoryMakanan::latest()->get();
        $menumakanan = MenuMakanan::all();
        return view('LandingPage.MenuMakanan.index', compact('categories','menumakanan'));
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all categories from the database
    $categories = CategoryMakanan::all();

    // Return the view and pass the categories variable
    return view('LandingPage.MenuMakanan.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryMakananRequest $request)
    {
        // Validasi sudah ditangani oleh StoreCategoryMakananRequest

        // Cek apakah nama kategori sudah ada
        if (CategoryMakanan::where('name', $request->name)->exists()) {
            // Kembalikan dengan pesan error jika nama sudah ada
            return back()->withErrors(['name' => 'Nama kategori sudah ada, silakan pilih nama lain.'])->withInput();
        }

        // Buat slug dan simpan data
        $data = $request->validated(); // Ambil data yang sudah divalidasi
        $data['slug'] = Str::slug($data['name']);
        
        CategoryMakanan::create($data);

        return back()->with('success', 'Kategori berhasil dibuat.');
    }
    /**
     * Display the specified resource.
     */
    public function show(CategoryMakanan $categoryMakanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryMakanan $categoryMakanan)
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

        CategoryMakanan::find($id)->update($data);
        return back()->with('success','Categories berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CategoryMakanan::find($id)->delete();
        return back()->with('success','Categories berhasil di delete');
    }
}
