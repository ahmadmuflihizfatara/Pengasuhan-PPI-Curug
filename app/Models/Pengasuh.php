<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengasuh extends Model
{
    protected $table = 'pengasuh';

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
        return self::HARI[$this->hari] ?? ucfirst($this->hari);
    }

    /** Kunci hari (senin..minggu) dari sebuah tanggal — dipakai untuk mencocokkan jadwal mingguan */
    public static function hariDari(\Carbon\Carbon $tanggal): string
    {
        return array_keys(self::HARI)[$tanggal->dayOfWeekIso - 1];
    }

    /** Pengasuh yang bertugas tetap pada tanggal tsb, berdasar hari dalam seminggu */
    public static function bertugasPada(\Carbon\Carbon $tanggal): ?self
    {
        return self::where('hari', self::hariDari($tanggal))->first();
    }
}
