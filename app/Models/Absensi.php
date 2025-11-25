<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'absensi';
    protected $fillable = ['siswa_id', 'tanggal', 'status','ket', 'method', 'waktu_absen'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }
}
