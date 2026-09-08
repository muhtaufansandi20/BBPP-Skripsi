<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusCutiTahunan extends Model
{
    protected $table = 'status_cuti_tahunans';

    protected $fillable = [
        'id_cuti_tahunan',
        'status',
        'catatan',
    ];

    public function pengajuanCutiTahunan()
    {
        return $this->belongsTo(PengajuanCutiTahunan::class, 'id_cuti_tahunan');
    }
}
