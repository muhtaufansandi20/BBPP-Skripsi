<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuStatusKatimkerKabag extends Model
{
    use HasFactory;

    protected $fillable = [
        'cu_status_admin_katimker_id',
        'cu_status_user_admin_id',
        'status',
        'catatan',
    ];

    public function adminKatimker()
    {
        return $this->belongsTo(CuStatusAdminKatimker::class, 'cu_status_admin_katimker_id');
    }

    public function kabagKabal()
    {
        return $this->hasOne(CuStatusKabagKabal::class, 'cu_status_katimker_kabag_id');
    }

    public function userAdmin()
    {
        return $this->belongsTo(CuStatusUserAdmin::class, 'cu_status_user_admin_id');
    }
    // Inside CuStatusKatimkerKabag model
    public function cuStatusKabagKabal()
    {
        return $this->hasOne(CuStatusKabagKabal::class, 'cu_status_katimker_kabag_id');
    }
}
