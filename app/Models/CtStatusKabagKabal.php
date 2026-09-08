<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtStatusKabagKabal extends Model
{
    use HasFactory;

    protected $table = 'ct_status_kabag_kabals';

    protected $fillable = [
        'id_ct_status_katimker_kabag',
        'status',
        'catatan',
    ];

    public function statusKatimkerKabag()
    {
        return $this->belongsTo(CtStatusKatimkerKabag::class, 'id_ct_status_katimker_kabag');
    }
}
