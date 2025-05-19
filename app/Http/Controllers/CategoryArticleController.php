<?php

namespace App\Http\Controllers;

use App\Models\CategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('LandingPage.article.category.index',[
            'categories' => CategoryArticle::latest()->get()
        ]);
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3'
        ]);
        $data['slug'] = Str::slug($data['name']);

        CategoryArticle::create($data);
        return redirect()->route('admin.CategoryArticleIndex')->with('success','Categories  berhasil di buat');


    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryArticle $categoryArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryArticle $categoryArticle)
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

        CategoryArticle::find($id)->update($data);
        return back()->with('success','Categories berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CategoryArticle::find($id)->delete();
        return back()->with('success','Categories berhasil di delete');
    }
}
