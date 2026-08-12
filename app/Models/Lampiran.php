<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $table = 'lampiran';
    protected $primaryKey = 'id_lampiran';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan', 'file_path', 'tipe_file'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}