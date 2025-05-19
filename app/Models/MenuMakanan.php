<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuMakanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', // pastikan kolom ini ada di tabel
        'title',
        'slug',
        'desc',
        'img',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryMakanan::class, 'category_id', 'id');
    }
    
}
