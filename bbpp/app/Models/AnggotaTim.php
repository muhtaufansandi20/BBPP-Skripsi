<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaTim extends Model
{
    
    protected $table = 'anggota_tims';
    protected $fillable = [
        'tim_id', 'user_id', 'role',
    ];

     // Relasi ke tabel TimKerja
    public function tim()
    {
        return $this->belongsTo(TimKerja::class, 'tim_id');
    }

    // Relasi ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
