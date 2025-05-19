<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialMedias = SocialMedia::all();
        return view('LandingPage.sosmed.index', compact('socialMedias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('LandingPage.sosmed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon_class' => 'required',
            'url' => 'required|url'
        ]);

        SocialMedia::create($request->all());
        return redirect()->route('admin.SosmedIndex')->with('success', 'Social media link added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $sosmed = SocialMedia::findOrFail($id); // Mengambil data berdasarkan ID
    return view('LandingPage.sosmed.edit', compact('sosmed'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $sosmed = SocialMedia::findOrFail($id); // Pastikan $id digunakan untuk mencari data
    $request->validate([
        'name' => 'required',
        'icon_class' => 'required',
        'url' => 'required|url',
    ]);

    $sosmed->update($request->all());

    return redirect()->route('admin.SosmedIndex')->with('success', 'Social media link updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sosmed = SocialMedia::findOrFail($id); // Cari data berdasarkan ID
        $sosmed->delete(); // Hapus data
    
        return redirect()->route('admin.SosmedIndex')->with('success', 'Social media link deleted successfully.');
    }
}
