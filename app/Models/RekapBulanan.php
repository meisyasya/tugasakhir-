<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBulanan extends Model
{
    use HasFactory;
    protected $table = 'rekap_bulanan';
    protected $fillable = [
        'balita_id', 'tanggal', 'usia', 'bb', 'tb', 'lingkar_kepala','imt', 'status_gizi', 'hasil_diagnosis'
    ];
    
    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    
    
}
