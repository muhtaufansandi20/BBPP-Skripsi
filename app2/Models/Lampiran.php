<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = 'lampirans';
    protected $fillable = [
        'id_pengajuan_cuti',
        'nama_doc',
        'file_path',
        'uploaded_at',
        'description',
    ];

    public function pengajuanCuti()
    {
        return $this->belongsTo(PengajuanCutiUmum::class, 'id_pengajuan_cuti', 'id');
    }
}
