<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimKerja extends Model
{
    protected $table = 'tim_kerjas';
    protected $fillable = [
        'nama_tim',
    ];
    
    public function tim()
    {
        return $this->belongsTo(TimKerja::class, 'tim_id');
    }

}
