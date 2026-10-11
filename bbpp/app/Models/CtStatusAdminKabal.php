<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CtStatusAdminKabal extends Model
{
    use HasFactory;

    protected $table = 'ct_status_admin_kabals';

    protected $fillable = [
        'id_ct_status_user_admin',
        'status',
        'catatan'
    ];

    public function statusUserAdmin()
    {
        return $this->belongsTo(CtStatusUserAdmin::class, 'id_ct_status_user_admin');
    }
}
