<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user', 'id_admin', 'id_kategori',
        'judul_laporan', 'isi_laporan', 'tanggal_kejadian',
        'lokasi_kejadian', 'anonim', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLaporan::class, 'id_kategori', 'id_kategori');
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'id_laporan', 'id_laporan');
    }

    public function hasilLaporan()
    {
        return $this->hasMany(HasilLaporan::class, 'id_laporan', 'id_laporan');
    }

    public function logStatus()
    {
        return $this->hasMany(LogStatus::class, 'id_laporan', 'id_laporan');
    }
}
