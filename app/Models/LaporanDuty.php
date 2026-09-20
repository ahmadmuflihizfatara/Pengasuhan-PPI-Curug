<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanDuty extends Model
{
    protected $table = 'laporan_duty';

    protected $fillable = [
        'tanggal',
        'mahasiswa_id',
        'keterangan',
        'dilaporkan_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh');
    }
}
