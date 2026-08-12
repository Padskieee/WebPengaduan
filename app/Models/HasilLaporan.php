<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilLaporan extends Model
{
    protected $table = 'hasil_laporan';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan', 'id_admin', 'judul_output',
        'deskripsi_output', 'tanggal_publish', 'status_publish'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function lampiranHasil()
    {
        return $this->hasMany(LampiranHasil::class, 'id_hasil', 'id_hasil');
    }
}
