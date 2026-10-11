<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEditKct extends Model
{
    use HasFactory;

    protected $table = 'log_edit_kcts';

    protected $fillable = [
        'id_kuota_cuti_tahunan',
        'date_edit',
        'time_edit',
    ];

    /**
     * Relasi ke tabel kuota_cuti_tahunan.
     */
    public function kuotaCutiTahunan()
    {
        return $this->belongsTo(KuotaCutiTahunan::class, 'id_kuota_cuti_tahunan');
    }
}
