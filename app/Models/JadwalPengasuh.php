<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPengasuh extends Model
{
    protected $table = 'jadwal_pengasuh';

    protected $fillable = [
        'tanggal',
        'pengasuh_id',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pengasuh()
    {
        return $this->belongsTo(Pengasuh::class);
    }
}
