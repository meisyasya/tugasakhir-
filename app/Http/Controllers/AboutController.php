<?php

namespace App\Http\Controllers;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first(); // Mengambil header pertama
        return view('LandingPage.about.index', compact('about'));
    }

    public function update(Request $request, $id)
{
    // Validasi input dari form
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Mencari about berdasarkan ID yang diberikan
    $about = About::findOrFail($id);

    // Jika ada file gambar yang diupload
    if ($request->hasFile('image')) {
        // Menghapus gambar lama jika ada
        if ($about->image) {
            Storage::delete('public/about/' . $about->image);
        }

        // Mengupload gambar baru
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/about', $fileName); 
        $about->image = $fileName; // Simpan nama file di database
    }

    // Update data lainnya kecuali gambar
    $about->title = $request->input('title');
    $about->description = $request->input('description');
    $about->save(); // Simpan perubahan ke database

    // Redirect kembali dengan pesan sukses
    return redirect()->route('admin.about')->with('success', 'Data berhasil diperbarui');
}
}
