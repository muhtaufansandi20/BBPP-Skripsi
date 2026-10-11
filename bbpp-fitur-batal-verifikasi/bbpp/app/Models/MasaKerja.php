<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasaKerja extends Model
{
    use HasFactory;
    protected $table = 'masa_kerja';
    protected $fillable = [
        'user_id',
        'jumlah_masa_kerja'
        ];
}
