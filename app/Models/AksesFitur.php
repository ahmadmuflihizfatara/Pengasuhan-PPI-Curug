<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesFitur extends Model
{
    protected $table = 'akses_fitur';

    const JADWAL_PENGASUH = 'jadwal_pengasuh';
    const DUTY_TARUNA     = 'duty_taruna';
    const APEL            = 'apel';
    const KELUHAN_BARAK   = 'keluhan_barak';

    /** Fitur yang izinnya dikelola admin lewat tab Akses */
    const DAFTAR = [
        self::JADWAL_PENGASUH => [
            'label' => 'Jadwal Pengasuh',
            'ikon'  => 'fa-user-clock',
            'warna' => '#4a3aa7',
            'ket'   => 'Izinkan pengasuh generate dan menukar jadwal jaga pengasuh.',
        ],
        self::DUTY_TARUNA => [
            'label' => 'Duty Taruna',
            'ikon'  => 'fa-users-rectangle',
            'warna' => '#1baf7a',
            'ket'   => 'Izinkan pengasuh mengisi dan mengubah daftar duty taruna mingguan.',
        ],
        self::APEL => [
            'label' => 'Data Apel',
            'ikon'  => 'fa-flag',
            'warna' => '#eb6834',
            'ket'   => 'Izinkan pengasuh mengisi, mengubah, dan menghapus data apel.',
        ],
        self::KELUHAN_BARAK => [
            'label' => 'Keluhan Barak',
            'ikon'  => 'fa-door-open',
            'warna' => '#d63384',
            'ket'   => 'Izinkan pengasuh mengelola dan memproses pengajuan keluhan barak taruna.',
        ],
    ];

    protected $fillable = ['fitur', 'diizinkan', 'diubah_oleh'];

    protected $casts = ['diizinkan' => 'boolean'];

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }

    /**
     * Apakah fitur boleh diubah oleh pengasuh.
     * Default true kalau barisnya belum ada — sistem tetap jalan sebelum admin mengatur.
     */
    public static function diizinkan(string $fitur): bool
    {
        return (bool) (self::where('fitur', $fitur)->value('diizinkan') ?? true);
    }

    /** Semua fitur beserta statusnya, terurut sesuai DAFTAR */
    public static function semua()
    {
        $tersimpan = self::with('pengubah')->get()->keyBy('fitur');

        return collect(self::DAFTAR)->map(fn ($info, $key) => [
            'key'       => $key,
            'label'     => $info['label'],
            'ikon'      => $info['ikon'],
            'warna'     => $info['warna'],
            'ket'       => $info['ket'],
            'diizinkan' => (bool) ($tersimpan[$key]->diizinkan ?? true),
            'pengubah'  => $tersimpan[$key]->pengubah->name ?? null,
            'diubah'    => $tersimpan[$key]->updated_at ?? null,
        ])->values();
    }
}
