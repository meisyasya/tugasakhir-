<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\About;
use App\Models\CategoryMakanan;
use App\Models\MenuMakanan;
use App\Models\JadwalPosyandu;

class HomeController extends Controller
{
    public function index()
    {
        //parshing data
        $headers = Header::first();
        $abouts = About::first();
        $kategori_makanan = CategoryMakanan::all();
        $menumakanan = MenuMakanan::all();
        $jadwal = JadwalPosyandu::all();
        return view ('home.index',compact(
            'headers',
            'abouts',
            'kategori_makanan',
            'menumakanan',
            'jadwal'

        ));
    }
    public function show($slug)
    {
    $menu = MenuMakanan::where('slug', $slug)->firstOrFail();
    return view('home.detailmakanan', compact('menu'));
    }


}
