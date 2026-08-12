<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatus extends Model
{
    protected $table = 'log_status';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan', 'status', 'keterangan', 'updated_by'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
