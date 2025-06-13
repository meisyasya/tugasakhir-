<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\About;
use App\Models\CategoryMakanan;
use App\Models\MenuMakanan;
use App\Models\JadwalPosyandu;
use App\Models\CategoryArticle;
use App\Models\Article;
use App\Models\CategoryGaleri;
use App\Models\Galeri;

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
        $categories = CategoryArticle::all();
        $articles = Article::orderBy('publish_date', 'desc')->take(5)->get();
        $galeris = Galeri::all();
        $galeri_categories = CategoryGaleri::all(); // Ambil semua kategori galeri
        return view ('home.index',compact(
            'headers',
            'abouts',
            'kategori_makanan',
            'menumakanan',
            'jadwal',
            'categories',
            'articles',
           'galeris',
           'galeri_categories'

        ));
    }
    public function show($slug)
    {
    $menu = MenuMakanan::where('slug', $slug)->firstOrFail();
    return view('home.detailmakanan', compact('menu'));
    }
    public function showberita($slug)
    {
    $menu = Article::where('slug', $slug)->firstOrFail();
    return view('home.detail_berita', compact('menu'));
    }



}
