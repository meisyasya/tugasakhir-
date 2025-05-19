<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','slug',
    ];
    protected $table = 'category_articles';

    // relasi has many category ->article
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
