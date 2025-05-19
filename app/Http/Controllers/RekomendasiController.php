<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekomendasi;

class RekomendasiController extends Controller
{
    public function index()
    {
        $rekomendasi = Rekomendasi::all();
        return view('rekomendasi.index',compact('rekomendasi'));
    }

    public function edit($id)
{
    $item = Rekomendasi::findOrFail($id);
    return view('rekomendasi.update', compact('item'));
}


    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'jenis_stunting' => 'required|string',
            'rekomendasi' => 'required|string',
        ]);
    
        // Cari rekomendasi berdasarkan ID
        $rekomendasi = Rekomendasi::findOrFail($id);
    
        // Update data
        $rekomendasi->update([
            'jenis_stunting' => $validated['jenis_stunting'],
            'rekomendasi' => $validated['rekomendasi'],
        ]);
    
        // Redirect atau response sesuai kebutuhan
        return redirect()->route('admin.RekomendasiIndex')->with('success', 'Rekomendasi berhasil diperbarui');
    }
    

}
