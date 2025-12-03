<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'wali_kelas';
    protected $fillable = ['NUPTK', 'user_id', 'kelas_id', 'tahun_ajar_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }
}
