<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'email', 'no_hp', 'password'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Override agar link verifikasi pakai route 'user.verification.verify'
     * bukan route default Laravel 'verification.verify'
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_user', 'id_user');
    }
}
