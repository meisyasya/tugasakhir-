<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Article extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','category_id', 'title', 'slug', 'desc', 'img', 'views', 'status', 'publish_date'];

    // relasi ke category(agar memanggil nama bukan angka di table )
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryArticle::class, 'category_id'); 
    }
    //relasi user
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

}
