<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage; 


class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header = Header::first(); // Mengambil header pertama
        return view('LandingPage.header.index', compact('header'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Mencari header berdasarkan ID yang diberikan
        $header = Header::findOrFail($id);

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            if ($header->image) {
                Storage::delete('public/header/' . $header->image);
            }

            // Mengupload gambar baru
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/header', $fileName); 
            $header->image = $fileName; // Simpan nama file di database
        }

        // Update data lainnya kecuali gambar
        $header->title = $request->input('title');
        $header->description = $request->input('description');
        $header->save(); // Simpan perubahan ke database

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.header')->with('success', 'Data berhasil diperbarui');
    }

   
}