<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'tahun_ajar';
    protected $fillable = ['tahun', 'status'];

    public function walikelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

     public function semesterAktif()
    {
        return $this->hasOne(Semester::class)->where('status', 'aktif');
    }
    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }
    public static function aktif()
    {
        return self::where('status', 'aktif')->first();
    }
}
