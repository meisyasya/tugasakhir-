<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'user_id',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'img',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'nik_ibu',
        'nama_ibu',
        'alamat_lengkap',
        'rt',
        'rw',
        'posyandu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Relasi ke Diagnosis (Satu balita memiliki banyak diagnosis)
    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'balita_id');
    }

    //relasi ke Data Stunting
    public function datastuntings()
    {
        return $this->hasMany(DataStunting::class);
    }
}
