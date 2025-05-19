<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreMenuMakananRequest;
use App\Http\Requests\UpdateMenuMakananRequest;
use App\Http\Requests\Rule;
use App\Models\CategoryMakanan;
use App\Models\MenuMakanan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class MenuMakananController extends Controller
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
    public function store(StoreMenuMakananRequest $request)
    {
        $data = $request->validated();
    
        // Pastikan title ada sebelum membuat slug
        if (!isset($data['title']) || empty($data['title'])) {
            return redirect()->route('menumakanan.create')->withErrors(['title' => 'Title is required']);
        }
    
        // Generate slug
        $data['slug'] = Str::slug($data['title']);
    
        // Simpan gambar jika ada
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/menumakanan', $filename, 'public'); // Simpan ke storage/app/public/images/menumakanan
            $data['img'] = 'images/menumakanan/' . $filename; // Simpan path relatif di database
        }
    
        MenuMakanan::create($data);
    
        return redirect()->route('admin.CategoriMakananIndex')->with('success', 'Menu Makanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuMakanan $menuMakanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuMakanan $menuMakanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuMakananRequest $request, $id)
    {
        $menu = MenuMakanan::findOrFail($id);
    
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
    
        return redirect()->route('admin.CategoriMakananIndex')->with('success', 'Menu makanan berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = MenuMakanan::findOrFail($id); // akan throw 404 jika data tidak ditemukan
        $menu->delete();
    
        return redirect()->route('admin.CategoriMakananIndex')->with('success', 'Data berhasil dihapus');
    }
    

}
