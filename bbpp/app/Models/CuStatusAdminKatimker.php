<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuStatusAdminKatimker extends Model
{
    use HasFactory;

    protected $fillable = [
        'cu_status_user_admin_id',
        'status',
        'catatan',
    ];

    public function userAdmin()
    {
        return $this->belongsTo(CuStatusUserAdmin::class, 'cu_status_user_admin_id');
    }

    public function cuStatusKatimkerKabag()
    {
        return $this->hasOne(CuStatusKatimkerKabag::class, 'cu_status_admin_katimker_id');
    }

}
