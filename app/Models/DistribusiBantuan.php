<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistribusiBantuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'balita_id',
        'user_id',
        'diagnosis_id',
        'tanggal_distribusi',
        'foto_bukti',
        'keterangan',
    ];

    public function datastunting()
{
    return $this->belongsTo(RekapStunting::class, 'diagnosis_id');
}


    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $table = 'distribusi_bantuans'; // kalau perlu




    



}
