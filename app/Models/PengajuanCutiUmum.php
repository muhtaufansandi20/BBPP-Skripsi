<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanCutiUmum extends Model
{
    protected $table = 'pengajuan_cuti_umums';
    protected $fillable = [
        'user_id',
        'jeniscuti_id', 
        'tgl_pengajuan',
        'tgl_mulai',
        'tgl_selesai',
        'jumlah_hari',
        'alasan',
        'catatan',
        'alamat_saat_cuti',
        'no_hp_cuti',
        'masa_kerja',
        'no_surat',
        'is_katimker',
        'is_kabag'
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Relasi ke tabel jenis_cuti
    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'jeniscuti_id');
    } 
    public function StatusAdminUmum()
    {
        return $this->hasOne(CuStatusUserAdmin::class, 'id_pengajuan_cuti_umum', 'id');
    }
    public function cuStatusUserAdmin()
    {
        return $this->hasOne(CuStatusUserAdmin::class, 'id_pengajuan_cuti_umum', 'id');
    }
    
    public function lampiran()
    {
        return $this->hasOne(Lampiran::class, 'id_pengajuan_cuti', 'id');
    }
    public function verifikasiTtd()
    {
        return $this->hasOne(VerifikasiTtdCutiUmum::class, 'pengajuan_cuti_umum_id');
    }

 // Relasi ke tabel status_cuti_umums
    public function statusCutiUmum()
    {
        return $this->hasOne(StatusCutiUmum::class, 'id_cuti_umum', 'id');
    }
}
