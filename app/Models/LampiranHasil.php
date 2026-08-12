<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranHasil extends Model
{
    protected $table = 'lampiran_hasil';
    protected $primaryKey = 'id_lampiran_hasil';
    public $timestamps = false;

    protected $fillable = [
        'id_hasil', 'jenis_lampiran', 'file_path', 'tipe_file'
    ];

    public function hasilLaporan()
    {
        return $this->belongsTo(HasilLaporan::class, 'id_hasil', 'id_hasil');
    }
}
