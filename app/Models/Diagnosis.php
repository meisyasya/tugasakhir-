<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnosis extends Model
{
    use HasFactory;
    protected $fillable = 
    ['balita_id', 
    'tanggal_diagnosis',
    'usia',
    'bb',
    'tb',
    'imt',
    'status_gizi',
    'hasil_diagnosis',
     ];

      // Relasi ke model Balita (Diagnosis belongs to one Balita)
    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }
    protected $table = 'diagnoses';  // Pastikan nama tabel sesuai

     
}


