<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'modul',
        'aksi',
        'deskripsi',
        'detail',
        'subject_type',
        'subject_id',
        'ip_address',
    ];

    protected $casts = [
        'detail' => 'array',
    ];

    // =====================
    // Relasi
    // =====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =====================
    // Accessor Tampilan
    // =====================

    /**
     * Warna badge berdasarkan modul
     */
    public function getModulColorAttribute(): string
    {
        return match ($this->modul) {
            'poin'  => '#764ba2',
            'acara' => '#38a169',
            'surat' => '#e07020',
            default => '#667eea',
        };
    }

    public function getModulBgColorAttribute(): string
    {
        return match ($this->modul) {
            'poin'  => '#f3eeff',
            'acara' => '#e6fff5',
            'surat' => '#fff4e6',
            default => '#eef0ff',
        };
    }

    /**
     * Warna badge berdasarkan aksi
     */
    public function getAksiColorAttribute(): string
    {
        return match ($this->aksi) {
            'tambah', 'buat'  => '#38a169',
            'hapus'           => '#e53e3e',
            'ubah', 'update'  => '#3182ce',
            'selesai'         => '#667eea',
            'tolak'           => '#e53e3e',
            'setujui'         => '#38a169',
            default           => '#888',
        };
    }

    public function getAksiBgColorAttribute(): string
    {
        return match ($this->aksi) {
            'tambah', 'buat'  => '#e6fff5',
            'hapus'           => '#fff0f0',
            'ubah', 'update'  => '#ebf4ff',
            'selesai'         => '#eef0ff',
            'tolak'           => '#fff0f0',
            'setujui'         => '#e6fff5',
            default           => '#f5f5f5',
        };
    }

    /**
     * Ikon Font Awesome berdasarkan modul
     */
    public function getModulIconAttribute(): string
    {
        return match ($this->modul) {
            'poin'  => 'fa-star',
            'acara' => 'fa-calendar-alt',
            'surat' => 'fa-envelope',
            default => 'fa-history',
        };
    }

    /**
     * Label modul yang lebih rapi
     */
    public function getModulLabelAttribute(): string
    {
        return match ($this->modul) {
            'poin'  => 'Poin',
            'acara' => 'Acara',
            'surat' => 'Surat',
            default => ucfirst($this->modul),
        };
    }

    /**
     * Label aksi yang lebih rapi
     */
    public function getAksiLabelAttribute(): string
    {
        return match ($this->aksi) {
            'tambah'  => 'Tambah',
            'hapus'   => 'Hapus',
            'ubah'    => 'Ubah',
            'buat'    => 'Buat',
            'update'  => 'Update',
            'selesai' => 'Selesai',
            'tolak'   => 'Tolak',
            'setujui' => 'Setujui',
            default   => ucfirst($this->aksi),
        };
    }
}
