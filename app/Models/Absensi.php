<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'absensi';
    protected $fillable = ['kelas_siswa_id', 'tanggal', 'status', 'semester_id', 'method', 'waktu_absen', 'keterangan'];

    public function kelassiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kelas_siswa_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function kelas()
    {
        return $this->hasOneThrough(Kelas::class, KelasSiswa::class, 'id', 'id', 'kelas_siswa_id', 'kelas_id');
    }

    public function tahunAjar()
    {
        return $this->kelas->waliKelas->tahunAjar();
    }
}
