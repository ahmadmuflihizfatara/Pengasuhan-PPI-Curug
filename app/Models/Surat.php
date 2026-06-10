<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'user_id',
        'diajukan_oleh',
        'nomor_surat',
        'jenis_surat',
        'perihal',
        'pengirim',
        'penerima',
        'tanggal_surat',
        'tanggal_terima',
        'status',
        'keterangan',
        'catatan_pengasuhan',
        'taruna_baca',
        'file_path',
    ];

    protected $casts = [
        'tanggal_surat'  => 'date',
        'tanggal_terima' => 'date',
        'taruna_baca'    => 'boolean',
    ];

    /** Taruna yang mengajukan surat */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Apakah surat ini diajukan oleh taruna */
    public function isDiajukanTaruna(): bool
    {
        return $this->user_id !== null;
    }

    public static function jenisSuratList(): array
    {
        return [
            'Surat Proposal',
            'Surat Izin',
            'Surat Permohonan',
            'Surat Keterangan',
            'Surat Undangan',
            'Surat Tugas',
            'Surat Lainnya',
        ];
    }

    public static function statusList(): array
    {
        return ['Diproses', 'Disetujui', 'Ditolak', 'Selesai'];
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'Diproses'  => '#e07020',
            'Disetujui' => '#38a169',
            'Ditolak'   => '#e53e3e',
            'Selesai'   => '#667eea',
            default     => '#999',
        };
    }

    public function getStatusBgColorAttribute(): string
    {
        return match ($this->status) {
            'Diproses'  => '#fff4e6',
            'Disetujui' => '#e6fff5',
            'Ditolak'   => '#fff0f0',
            'Selesai'   => '#eef0ff',
            default     => '#f0f0f0',
        };
    }
}
