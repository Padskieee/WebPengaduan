<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLaporan extends Model
{
    protected $table = 'kategori_laporan';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori', 'deskripsi'
    ];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kategori', 'id_kategori');
    }
}
