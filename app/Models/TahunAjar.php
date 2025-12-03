<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'tahun_ajar';
    protected $fillable = ['tahun', 'semester', 'status'];

    public function walikelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }
}
