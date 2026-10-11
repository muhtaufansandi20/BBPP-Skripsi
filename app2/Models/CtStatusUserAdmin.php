<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CtStatusUserAdmin extends Model
{
    use HasFactory;

    protected $table = 'ct_status_user_admins'; 

    protected $fillable = [
        'id_pengajuan_cuti_tahunan',
        'status',
        'catatan',
    ];


       public function user()
     {
         return $this->belongsTo(User::class, 'id_pengajuan_cuti_tahunan', 'id');
     }

    public function pengajuanCutiTahunan()
    {
        return $this->belongsTo(PengajuanCutiTahunan::class, 'id_pengajuan_cuti_tahunan', 'id');
    }

    public function ctStatusAdminKatimker()
    {
        return $this->hasOne(CtStatusAdminKatimker::class, 'id_ct_status_user_admin');
    }

    public function ctStatusKabagKabal()
    {
        return $this->hasOne(CtStatusKabagKabal::class, 'id_ct_status_user_admin');
    }

    public function ctStatusAdminKabal()
    {
        return $this->hasOne(CtStatusAdminKabal::class, 'id_ct_status_user_admin');
    }

}
