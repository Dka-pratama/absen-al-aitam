<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'wali';
    protected $fillable = ['NUPTK', 'user_id', 'kelas_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
