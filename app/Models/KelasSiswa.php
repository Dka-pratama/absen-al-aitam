<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'kelas_siswa';
    
    protected $fillable = ['kelas_id', 'siswa_id', 'tahun_ajar_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
