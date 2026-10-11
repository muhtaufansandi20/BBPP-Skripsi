<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika mengikuti standar Laravel, tapi baik untuk kejelasan)
    protected $table = 'hari_liburs';

    // Kolom-kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'tanggal',
        'nama',
        'tipe',
    ];

    // Opsional: Casting kolom tanggal agar otomatis menjadi instance Carbon
    protected $casts = [
        'tanggal' => 'date',
    ];
}