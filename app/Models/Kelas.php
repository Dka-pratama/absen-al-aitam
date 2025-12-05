<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'jurusan', 'angkatan'];

    // App\Models\Kelas.php
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id');
    }

    public function walikelas()
    {
        return $this->hasOne(WaliKelas::class);
    }
}
