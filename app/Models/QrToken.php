<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = ['kelas_id', 'tahun_ajar_id', 'token', 'expired_at', 'used'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
