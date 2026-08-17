<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluhanBarak extends Model
{
    protected $table = 'keluhan_barak';

    /**
     * Daftar asrama. Contoh sederhana — sesuaikan dengan studi kasus terbaru.
     */
    const ASRAMA = ['Curug 1', 'Tower'];

    /**
     * Daftar lorong per asrama. Contoh sederhana — sesuaikan dengan studi kasus terbaru.
     */
    const LORONG = [
        'Curug 1' => ['Lorong A', 'Lorong B', 'Lorong C', 'Lorong D'],
        'Tower'   => ['Lantai 1', 'Lantai 2', 'Lantai 3', 'Lantai 4'],
    ];

    protected $fillable = [
        'user_id',
        'email',
        'nama',
        'tanggal_pengajuan',
        'prodi',
        'asrama',
        'lorong',
        'nomor_barak',
        'keterangan',
        'status',
        'catatan_pengasuhan',
        'taruna_baca',
        'lampiran',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'taruna_baca'       => 'boolean',
        'lampiran'          => 'array',
    ];

    /** Taruna yang mengajukan keluhan */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function statusList(): array
    {
        return ['Diajukan', 'Diproses', 'Selesai', 'Ditolak'];
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'Diajukan' => '#e07020',
            'Diproses' => '#3182ce',
            'Selesai'  => '#38a169',
            'Ditolak'  => '#e53e3e',
            default    => '#999',
        };
    }

    public function getStatusBgColorAttribute(): string
    {
        return match ($this->status) {
            'Diajukan' => '#fff4e6',
            'Diproses' => '#ebf4ff',
            'Selesai'  => '#e6fff5',
            'Ditolak'  => '#fff0f0',
            default    => '#f0f0f0',
        };
    }

    /** Nama panjang prodi, mengikuti daftar prodi mahasiswa */
    public function getProdiNamaAttribute(): string
    {
        return Mahasiswa::PRODI[$this->prodi]['nama'] ?? $this->prodi;
    }
}
