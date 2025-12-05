<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'siswa';
    protected $fillable = ['NISN', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function KelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }

    public function kelas()
    {
        return $this->hasOneThrough(
            Kelas::class, // model tujuan
            KelasSiswa::class, // model perantara
            'siswa_id', // FK di kelas_siswa
            'id', // PK di kelas
            'id', // PK siswa
            'kelas_id', // kelas_id di kelas_siswa
        );
    }

    public function absensi()
    {
        return $this->hasManyThrough(
            Absensi::class,
            KelasSiswa::class,
            'siswa_id', // Foreign key on KelasSiswa table
            'kelas_siswa_id', // Foreign key on Absensi table
            'id', // Local key on Siswa table
            'id', // Local key on KelasSiswa table
        );
    }
}
