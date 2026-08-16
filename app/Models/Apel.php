<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apel extends Model
{
    use HasFactory;

    protected $table = 'apel';

    const SESI_PAGI   = 'pagi';
    const SESI_MALAM  = 'malam';
    const SESI_KHUSUS = 'khusus';

    /** Sesi rutin — dibatasi satu per tanggal lewat unique index sesi_unik */
    const SESI_RUTIN = [
        self::SESI_PAGI  => ['label' => 'Apel Pagi',  'jam_default' => '06:30', 'ikon' => 'fa-sun',  'warna' => '#eda100'],
        self::SESI_MALAM => ['label' => 'Apel Malam', 'jam_default' => '19:00', 'ikon' => 'fa-moon', 'warna' => '#4a3aa7'],
    ];

    protected $fillable = [
        'tanggal',
        'sesi',
        'sesi_unik',
        'nama_apel',
        'jam',
        'pembina',
        'pembina_user_id',
        'lokasi',
        'informasi',
        'keterangan',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function booted(): void
    {
        // sesi_unik menegakkan "satu apel pagi/malam per tanggal" di level DB.
        // Apel khusus bernilai NULL supaya boleh banyak dalam satu tanggal.
        static::saving(function (Apel $apel) {
            $apel->sesi_unik = array_key_exists($apel->sesi, self::SESI_RUTIN) ? $apel->sesi : null;
        });
    }

    public function pembinaUser()
    {
        return $this->belongsTo(User::class, 'pembina_user_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /** Judul tampilan: nama khusus kalau ada, selain itu label sesi rutin */
    public function getJudulAttribute(): string
    {
        if ($this->sesi === self::SESI_KHUSUS) {
            return $this->nama_apel ?: 'Apel Khusus';
        }

        return self::SESI_RUTIN[$this->sesi]['label'] ?? ucfirst($this->sesi);
    }

    public function getIkonAttribute(): string
    {
        return self::SESI_RUTIN[$this->sesi]['ikon'] ?? 'fa-flag';
    }

    public function getWarnaAttribute(): string
    {
        return self::SESI_RUTIN[$this->sesi]['warna'] ?? '#1baf7a';
    }

    /** Label untuk dropdown: "16 Agu 2026 · Apel Pagi" */
    public function getLabelDropdownAttribute(): string
    {
        return $this->tanggal->locale('id')->isoFormat('D MMM Y') . ' · ' . $this->judul;
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('tanggal')->orderByDesc('jam');
    }
}
