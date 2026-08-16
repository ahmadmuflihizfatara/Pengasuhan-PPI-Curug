<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogPergerakan extends Model
{
    use HasFactory;

    protected $table = 'log_pergerakan';

    // Status Constants
    const STATUS_BERANGKAT = 'berangkat';
    const STATUS_KEMBALI   = 'kembali';

    // Kategori Constants
    const KAT_PERIZINAN       = 'perizinan';
    const KAT_EKSTRAKURIKULER = 'ekstrakurikuler';
    const KAT_OLAHRAGA        = 'olahraga';

    protected $fillable = [
        'user_id',
        'nama',
        'npm',
        'prodi',
        'kategori',
        'subkategori',
        'keterangan_keluhan',
        'nama_ekskul',
        'jumlah_anggota',
        'daftar_anggota',
        'lokasi_kegiatan',
        'rute',
        'pengikut',
        'foto_keberangkatan',
        'waktu_berangkat',
        'estimasi_kembali',
        'status',
        'waktu_kembali',
        'foto_kembali',
        'catatan_kembali',
        'created_by',
        'verified_by',
    ];

    protected $casts = [
        'waktu_berangkat'  => 'datetime',
        'estimasi_kembali' => 'datetime',
        'waktu_kembali'    => 'datetime',
        'jumlah_anggota'   => 'integer',
    ];

    /**
     * Relasi ke user taruna jika terkait akun
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * User yang membuat log
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Petugas/Pengasuh yang memverifikasi kepulangan
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper status
    public function isBelumKembali(): bool
    {
        return $this->status === self::STATUS_BERANGKAT;
    }

    public function isSudahKembali(): bool
    {
        return $this->status === self::STATUS_KEMBALI;
    }

    public function getStatusLabel(): string
    {
        return $this->status === self::STATUS_BERANGKAT ? 'BELUM KEMBALI' : 'SUDAH KEMBALI';
    }

    public function getStatusBadgeHtml(): string
    {
        if ($this->status === self::STATUS_BERANGKAT) {
            return '<span class="badge-status-belum"><span class="pulse-dot"></span> BELUM KEMBALI</span>';
        }
        return '<span class="badge-status-sudah"><i class="fas fa-check-circle me-1"></i> SUDAH KEMBALI</span>';
    }

    public function getKategoriBadgeHtml(): string
    {
        switch ($this->kategori) {
            case self::KAT_PERIZINAN:
                return '<span class="badge-kat-perizinan"><i class="fas fa-notes-medical me-1"></i> Perizinan</span>';
            case self::KAT_EKSTRAKURIKULER:
                return '<span class="badge-kat-ekskul"><i class="fas fa-cogs me-1"></i> Ekstrakurikuler</span>';
            case self::KAT_OLAHRAGA:
                return '<span class="badge-kat-olahraga"><i class="fas fa-running me-1"></i> Olahraga</span>';
            default:
                return '<span class="badge-kat-default">' . ucfirst($this->kategori) . '</span>';
        }
    }

    /**
     * Hitung durasi berada di luar (atau durasi total kegiatan jika sudah kembali)
     */
    public function getDurasiFormatted(): string
    {
        if (!$this->waktu_berangkat) return '-';
        $end = $this->waktu_kembali ?? Carbon::now();
        $diffMinutes = $this->waktu_berangkat->diffInMinutes($end);
        
        $hours = floor($diffMinutes / 60);
        $minutes = $diffMinutes % 60;

        if ($hours > 0) {
            return "{$hours} jam {$minutes} mnt";
        }
        return "{$minutes} menit";
    }
}
