<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtStatusKatimkerKabag extends Model
{
    use HasFactory;

    protected $table = 'ct_status_katimker_kabags';

    protected $fillable = [
        'id_ct_status_admin_katimker',
        'id_ct_status_user_admin',
        'status',
        'catatan',
    ];

    public function statusAdminKatimker()
    {
        return $this->belongsTo(CtStatusAdminKatimker::class, 'id_ct_status_admin_katimker');
    }

    public function statusUserAdmin()
    {
        return $this->belongsTo(CtStatusUserAdmin::class, 'id_ct_status_user_admin');
    }

    public function ctStatusKabagKabal()
    {
        return $this->hasOne(CtStatusKabagKabal::class, 'id_ct_status_katimker_kabag', 'id');
    }
}