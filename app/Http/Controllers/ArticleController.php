<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CategoryArticle;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Ambil data artikel terbaru beserta kategori-nya
    $articles = Article::with('category')->latest()->paginate(10);

    // Kirim data ke view
    return view('LandingPage.article.article.index', compact('articles'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('LandingPage.article.article.create',[
             'categories' => CategoryArticle::all()
         ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
     {
         // Debug: Cek apakah request diterima dengan benar
         Log::info('Data yang dikirim:', $request->all());
     
         // Validasi data
         $data = $request->validated();
     
         // Upload gambar jika ada
         if ($request->hasFile('img')) {
             $file = $request->file('img');
             $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
             $file->storeAs('public/uploads/articles/', $fileName);
             $data['img'] = $fileName;
         }
     
         // Tambahkan user ID & slug
         $data['user_id'] = auth()->user()->id;
         $data['slug'] = Str::slug($data['title']);
     
         // Simpan ke database
         $article = Article::create($data);
     
         // Debug: Cek apakah artikel berhasil dibuat
         Log::info('Artikel berhasil dibuat:', ['id' => $article->id]);
     
         return redirect()->route('admin.ArticleIndex')->with('success', 'Artikel berhasil dibuat.');
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $article = Article::with('User','category')->findOrFail($id); // Temukan artikel berdasarkan ID
       return view('LandingPage.article.article.show', compact('article')); // Tampilkan detail artikel
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('LandingPage.article.article.update',[
            'article' => Article::find($id),
            'categories' => CategoryArticle::get()
        ]); 
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, string $id)
    {
        // Mengambil data yang sudah divalidasi
        $data = $request->validated();
        
        // Log data validasi
        Log::info('Data validasi: ', $data);
        
        // Jika ada gambar baru yang diunggah
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/articles/', $fileName);
    
            // Hapus gambar lama jika ada
            if ($request->oldImg) {
                Storage::delete('public/uploads/articles/'.$request->oldImg);
            }
    
            // Simpan nama file baru di database
            $data['img'] = $fileName;
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $data['img'] = $request->oldImg;
        }
    
        $data['user_id'] = auth()->user()->id;
        // Generate slug dari title
        $data['slug'] = Str::slug($data['title']);
        
        // Update data artikel berdasarkan ID
        Article::find($id)->update($data);
    
        // Redirect ke halaman indeks artikel dengan pesan sukses
        return redirect()->route('admin.ArticleIndex')->with('success', 'Data article has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info("Attempting to delete article with ID: $id");
        
        $article = Article::find($id);
        if (!$article) {
            Log::warning("Article not found for ID: $id");
            return response()->json(['success' => false, 'message' => 'Article not found'], 404);
        }

        // Hapus gambar jika ada
        if ($article->img) {
            $imagePath = 'public/uploads/articles/' . $article->img;
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
                Log::info("Deleted image: " . $article->img);
            } else {
                Log::warning("Image not found: " . $article->img);
            }
        }

        $article->delete();
        Log::info("Article deleted successfully: $id");
        
        return response()->json(['success' => true, 'message' => 'Article deleted successfully'], 200);
    }
}
