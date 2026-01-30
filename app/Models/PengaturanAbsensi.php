<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanAbsensi extends Model
{
    protected $table = 'pengaturan_absensi';

    protected $fillable = [
        'lat_sekolah',
        'lng_sekolah',
        'radius_meter',
    ];
}

