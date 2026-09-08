<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    use HasFactory;

    protected $table = 'tanda_tangans';

    protected $fillable = [
        'role',
        'gambar_ttd',
        'nama_file',
        'tanggal_upload'
    ];

}