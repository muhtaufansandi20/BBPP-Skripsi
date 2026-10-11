<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatCutiUmum extends Model
{
    protected $table = 'riwayat_cuti_umums';
    protected $fillable = ['id_cuti', 'user_id', 'jumlah_pengambilan'];
}
