<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuotaCutiTahunan extends Model
{
    protected $table = 'kuota_cuti_tahunan';
    protected $fillable = ['user_id', 'kuota_n', 'kuota_n1', 'kuota_n2', 'catatan'];
}
