<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas','jurusan', 'angkatan'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function walikelas()
    {
        return $this->hasOne(WaliKelas::class);
    }
}
