<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanCutiTahunan extends Model
{
    protected $table = 'pengajuan_cuti_tahunans';
    protected $fillable = [
        'user_id',
        'tgl_pengajuan',
        'tgl_mulai',
        'tgl_selesai',
        'lama_cuti',
        'alasan', 
        'catatan',
        'alamat_saat_cuti',
        'no_hp_cuti',
        'masa_kerja',
        'no_surat',
        'is_katimker',
        'is_kabag'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function statusAdmin()
    {
        return $this->hasOne(CtStatusUserAdmin::class, 'id_pengajuan_cuti_tahunan', 'id');
    }
    public function ctStatusUserAdmin()
    {
        return $this->hasOne(CtStatusUserAdmin::class, 'id_pengajuan_cuti_tahunan');
    }
    public function ctStatusAdminKatimker()
    {
        return $this->hasOne(CtStatusAdminKatimker::class, 'id_ct_status_user_admin', 'id');
    }

    public function kuota()
    {
        return $this->hasOne(KuotaCutiTahunan::class, 'user_id', 'user_id');
    }
    
    public function verifikasiTtd()
    {
        return $this->hasOne(VerifikasiTtdCutiTahunan::class, 'pengajuan_cuti_tahunan_id');
    }
    
    // Relationship dengan StatusCutiTahunan
    public function statusCutiTahunan()
    {
        return $this->hasOne(StatusCutiTahunan::class, 'id_cuti_tahunan');
    }
}
