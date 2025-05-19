<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class CategoryMakanan extends Model
{
    use HasFactory;
    protected $table = 'category_makanans'; 

    protected $fillable = [
        'name','slug',
    ];
    public function menuMakanans(): HasMany
    {
        return $this->hasMany(MenuMakanan::class, 'category_id', 'id');
    }
    
}
