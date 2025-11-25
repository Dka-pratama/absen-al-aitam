<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'angkatan'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function wali()
    {
        return $this->hasOne(Wali::class);
    }
}
