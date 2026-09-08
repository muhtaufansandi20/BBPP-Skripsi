<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiTtdCutiUmum extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_ttd_cuti_umums';

    protected $fillable = [
        'pengajuan_cuti_umum_id',
        'ttd_kabag',
        'ttd_kabalai',
        'tanggal_ttd_kabag',
        'tanggal_ttd_kabalai'
    ];

    /**
     * Mendapatkan pengajuan cuti umum yang terkait dengan verifikasi ini
     */
    public function pengajuanCutiUmum()
    {
        return $this->belongsTo(PengajuanCutiUmum::class, 'pengajuan_cuti_umum_id');
    }
}