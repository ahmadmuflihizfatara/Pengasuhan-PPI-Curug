<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Pengasuh extends Model
{
    protected $table = 'pengasuh';

    /** Jumlah pengasuh yang bertugas setiap hari */
    const PER_HARI = 3;

    /** Urutan hari Senin→Minggu + label tampilan */
    const HARI = [
        'senin'  => 'Senin',
        'selasa' => 'Selasa',
        'rabu'   => 'Rabu',
        'kamis'  => 'Kamis',
        'jumat'  => 'Jumat',
        'sabtu'  => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    protected $fillable = [
        'user_id',
        'nama',
        'hari',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalPengasuh::class);
    }

    public function getHariLabelAttribute(): string
    {
        return self::HARI[$this->hari ?? ''] ?? 'Belum dialokasikan';
    }

    /** Kunci hari (senin..minggu) dari sebuah tanggal — dipakai untuk mencocokkan jadwal mingguan */
    public static function hariDari(\Carbon\Carbon $tanggal): string
    {
        return array_keys(self::HARI)[$tanggal->dayOfWeekIso - 1];
    }

    /** Pengasuh default yang bertugas pada tanggal tsb, berdasar alokasi hari dalam seminggu */
    public static function bertugasPada(\Carbon\Carbon $tanggal): Collection
    {
        return self::where('hari', self::hariDari($tanggal))->orderBy('nama')->get();
    }

    /** Urut Senin→Minggu, yang belum dialokasikan di akhir */
    public function scopeUrutHari($query)
    {
        return $query->orderByRaw("hari IS NULL, FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu','minggu')")
                     ->orderBy('nama');
    }
}
