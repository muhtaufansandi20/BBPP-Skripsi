<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuStatusUserAdmin extends Model
{
    use HasFactory;

    protected $table = 'cu_status_user_admins';

    protected $fillable = [
        'id_pengajuan_cuti_umum',
        'status',
        'catatan',
    ];

    /**
     * Relasi ke tabel pengajuan_cuti_umums
     */
    public function pengajuanCutiUmum()
    {
        return $this->belongsTo(PengajuanCutiUmum::class, 'id_pengajuan_cuti_umum');
    }
    public function cuStatusAdminKatimker()
    {
        return $this->hasOne(CuStatusAdminKatimker::class, 'cu_status_user_admin_id');
    }
    public function cuStatusKatimkerKabag()
    {
        return $this->hasOne(CuStatusKatimkerKabag::class, 'cu_status_user_admin_id');
    }
    public function cuStatusKabagKabal()
    {
        return $this->hasOne(CuStatusKabagKabal::class, 'cu_status_user_admin_id');
    }
    public function cuStatusAdminKabal()
    {
        return $this->hasOne(CuStatusAdminKabal::class, 'cu_status_user_admin_id');
    }
}
