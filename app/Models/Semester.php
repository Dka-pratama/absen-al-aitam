<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $fillable = [
        'tahun_ajar_id',
        'name',        // ganjil | genap
        'status',      // aktif | nonaktif
    ];

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }


    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public static function aktif()
    {
        return static::where('status', 'aktif')->first();
    }
}
