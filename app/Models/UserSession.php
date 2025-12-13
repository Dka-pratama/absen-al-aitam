<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'login_at',
        'last_activity_at',
        'logout_at',
        'duration_minutes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

