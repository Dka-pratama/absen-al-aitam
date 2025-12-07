<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Kelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'jurusan', 'angkatan'];

    // App\Models\Kelas.php
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa')->withPivot('tahun_ajar_id')->withTimestamps();
    }

    function aktif()
    {
        return DB::table('tahun_ajar')->where('is_active', 1)->value('id');
    }

    public function walikelas()
    {
        return $this->hasOne(WaliKelas::class);
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_id');
    }
}
