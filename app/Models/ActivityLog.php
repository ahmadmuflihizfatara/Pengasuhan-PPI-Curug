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
    // Tampilan (PPI Curug Glass)
    // =====================

    /** [label, ikon, varian ds-badge] per modul yang dicatat sistem */
    const MODUL = [
        'poin'           => ['Poin', 'fa-scale-balanced', 'accent'],
        'acara'          => ['Acara', 'fa-calendar-days', 'success'],
        'apel'           => ['Apel', 'fa-clipboard-check', 'success'],
        'surat'          => ['Surat', 'fa-envelope-open-text', 'warning'],
        'berita'         => ['Berita', 'fa-newspaper', 'info'],
        'reward'         => ['Reward', 'fa-award', 'warning'],
        'keluhan-barak'  => ['Keluhan Barak', 'fa-door-open', 'danger'],
        'konsinyir'      => ['Konsinyir', 'fa-user-lock', 'danger'],
        'laporan_duty'   => ['Laporan Duty', 'fa-notes-medical', 'danger'],
        'log pergerakan' => ['Log Gerbang', 'fa-person-walking', 'warning'],
        'nilai_taruna'   => ['Nilai Taruna', 'fa-chart-line', 'accent'],
        'jadwal'         => ['Jadwal', 'fa-calendar-week', 'info'],
        'duty'           => ['Duty Taruna', 'fa-user-group', 'info'],
        'akses'          => ['Hak Akses', 'fa-shield-halved', 'dark'],
        'akses_khusus'   => ['Akses Khusus', 'fa-key', 'dark'],
    ];

    /** Label rapi untuk kode modul/aksi apa pun (dipakai juga di dropdown filter) */
    public static function labelModul(string $modul): string
    {
        return self::MODUL[$modul][0] ?? ucwords(str_replace(['_', '-'], ' ', $modul));
    }

    public static function labelAksi(string $aksi): string
    {
        return ucwords(str_replace('_', ' ', $aksi));
    }

    /** [label, ikon, varian] modul log ini */
    public function modulMeta(): array
    {
        return self::MODUL[$this->modul] ?? [self::labelModul($this->modul), 'fa-clock-rotate-left', 'accent'];
    }

    /** Varian ds-badge aksi: hijau = membuat, merah = menghapus/menolak, biru = mengubah */
    public function getAksiVarianAttribute(): string
    {
        return match (true) {
            in_array($this->aksi, ['tambah', 'buat', 'isi', 'ajukan'])            => 'success',
            in_array($this->aksi, ['hapus', 'tolak', 'validasi_tolak'])           => 'danger',
            in_array($this->aksi, ['ubah', 'update', 'proses'])                   => 'info',
            in_array($this->aksi, ['setujui', 'validasi', 'validasi_setujui', 'selesai']) => 'accent',
            default                                                               => '',
        };
    }
}
