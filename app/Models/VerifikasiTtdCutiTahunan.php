<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiTtdCutiTahunan extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_ttd_cuti_tahunans';

    protected $fillable = [
        'pengajuan_cuti_tahunan_id',
        'ttd_kabag',
        'ttd_kabalai',
        'tanggal_ttd_kabag',
        'tanggal_ttd_kabalai'
    ];

    /**
     * Mendapatkan pengajuan cuti tahunan yang terkait dengan verifikasi ini
     */
    public function pengajuanCutiTahunan()
    {
        return $this->belongsTo(PengajuanCutiTahunan::class, 'pengajuan_cuti_tahunan_id');
    }
}