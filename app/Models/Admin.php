<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nama_admin', 'email', 'password', 'no_hp'
    ];

    protected $hidden = [
        'password'
    ];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_admin', 'id_admin');
    }

    public function hasilLaporan()
    {
        return $this->hasMany(HasilLaporan::class, 'id_admin', 'id_admin');
    }
}
