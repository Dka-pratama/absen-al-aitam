<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function username()
    {
        return 'username';
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
    public function wali()
    {
        return $this->hasOne(WaliKelas::class);
    }
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function hasVerifiedEmail()
    {
        if (!$this->email) {
            return true;
        }

        return !is_null($this->email_verified_at);
    }
}
