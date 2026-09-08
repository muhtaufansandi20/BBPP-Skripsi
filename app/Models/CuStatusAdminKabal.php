<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuStatusAdminKabal extends Model
{
    use HasFactory;

    protected $table = 'cu_status_admin_kabals';

    protected $fillable = [
        'cu_status_user_admin_id',
        'status',
        'catatan'
    ];

    public function statusUserAdmin()
    {
        return $this->belongsTo(CuStatusUserAdmin::class, 'cu_status_user_admin_id');
    }
}
