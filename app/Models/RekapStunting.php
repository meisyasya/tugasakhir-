<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapStunting extends Model
{
    use HasFactory;
    protected $table = 'rekap_stunting';

    protected $fillable = [
       'balita_id',
        'tanggal',
        'usia',
        'bb',
        'tb',
        'imt',
        'status_stunting',
        'catatan_bidan' 
    ];
    
    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }
    
}
