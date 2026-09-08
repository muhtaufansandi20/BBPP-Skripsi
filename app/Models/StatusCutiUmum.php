<?php
// Menyesuaikan model StatusCutiUmum dengan nama kolom di database
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusCutiUmum extends Model
{
    protected $table = 'status_cuti_umums';

    protected $fillable = [
        'id_cuti_umum', // Menggunakan nama kolom sesuai migrasi
        'status',
        'catatan',
    ];

    public function pengajuanCutiUmum()
    {
        return $this->belongsTo(PengajuanCutiUmum::class, 'id_cuti_umum');
    }
}