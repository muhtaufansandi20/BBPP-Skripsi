<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuStatusKabagKabal extends Model
{
    use HasFactory;

    protected $fillable = [
        'cu_status_katimker_kabag_id',
        'status',
        'catatan',
    ];

    public function katimkerKabag()
    {
        return $this->belongsTo(CuStatusKatimkerKabag::class, 'cu_status_katimker_kabag_id');
    }

}
