<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinMahasiswa extends Model
{
    protected $table = 'poin_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'npm',
        'nama_mahasiswa',
        'kelas',
        'kategori',
        'kegiatan',
        'tanggal',
        'nilai',
        'pengasuh',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'float',
    ];

    /**
     * Nilai efektif: positif untuk prestasi, negatif untuk pelanggaran
     */
    public function getNilaiEfektifAttribute(): float
    {
        return $this->kategori === 'prestasi' ? abs($this->nilai) : -abs($this->nilai);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
