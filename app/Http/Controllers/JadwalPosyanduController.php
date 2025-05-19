<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPosyandu;

class JadwalPosyanduController extends Controller
{
     public function index(){
        $jadwal = JadwalPosyandu::all();
        return view('JadwalPosyandu.index',  compact('jadwal'));
    }
    public function edit($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        return view('JadwalPosyandu.edit', compact('jadwal'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
        ]);

        $jadwal = JadwalPosyandu::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwalposyandu')->with('success', 'Jadwal berhasil diperbarui.');
    }

}
