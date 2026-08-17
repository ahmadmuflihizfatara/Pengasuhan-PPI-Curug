<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'reward';

    /** Kategori prestasi reward */
    const KATEGORI = ['Akademik', 'Non-Akademik'];

    const JENIS_INDIVIDU = 'individu';
    const JENIS_KELOMPOK = 'kelompok';

    protected $fillable = [
        'user_id',
        'mahasiswa_id',
        'email',
        'nama',
        'npm',
        'prodi',
        'tingkat',
        'jenis',
        'jumlah_anggota',
        'kategori',
        'tanggal_prestasi',
        'keterangan',
        'dokumen',
        'status',
        'catatan_pengasuhan',
        'taruna_baca',
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
        'taruna_baca'      => 'boolean',
        'dokumen'          => 'array',
    ];

    /** Taruna yang mengajukan reward */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public static function statusList(): array
    {
        return ['Diajukan', 'Diproses', 'Disetujui', 'Ditolak'];
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'Diajukan'  => '#e07020',
            'Diproses'  => '#3182ce',
            'Disetujui' => '#38a169',
            'Ditolak'   => '#e53e3e',
            default     => '#999',
        };
    }

    public function getStatusBgColorAttribute(): string
    {
        return match ($this->status) {
            'Diajukan'  => '#fff4e6',
            'Diproses'  => '#ebf4ff',
            'Disetujui' => '#e6fff5',
            'Ditolak'   => '#fff0f0',
            default     => '#f0f0f0',
        };
    }

    /** Nama panjang prodi, mengikuti daftar prodi mahasiswa */
    public function getProdiNamaAttribute(): string
    {
        return Mahasiswa::PRODI[$this->prodi]['nama'] ?? $this->prodi;
    }
}
