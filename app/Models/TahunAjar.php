<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'tahun_ajar';
    protected $fillable = ['tahun_ajaran', 'semester', 'status'];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
