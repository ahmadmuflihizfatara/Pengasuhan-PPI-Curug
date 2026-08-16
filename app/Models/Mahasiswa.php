<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    /**
     * Daftar program studi PPI Curug.
     * Sumber tunggal — dipakai seeder, form edit, dan filter tabel.
     * 'tingkat' = jumlah tingkat pada jenjang tersebut (D-4 = 4 tahun, D-3 = 3 tahun).
     */
    const PRODI = [
        'PNB' => ['nama' => 'Penerbang',                      'jenjang' => 'D-4', 'tingkat' => 4],
        'LLU' => ['nama' => 'Lalu Lintas Udara',              'jenjang' => 'D-4', 'tingkat' => 4],
        'TLB' => ['nama' => 'Teknik Listrik Bandara',         'jenjang' => 'D-4', 'tingkat' => 4],
        'TPU' => ['nama' => 'Teknik Pesawat Udara',           'jenjang' => 'D-4', 'tingkat' => 4],
        'PA'  => ['nama' => 'Penerangan Aeronautika',         'jenjang' => 'D-3', 'tingkat' => 3],
        'PKP' => ['nama' => 'Pertolongan Kecelakaan Pesawat', 'jenjang' => 'D-3', 'tingkat' => 3],
        'TMB' => ['nama' => 'Teknik Mekanikal Bandara',       'jenjang' => 'D-3', 'tingkat' => 3],
        'TBL' => ['nama' => 'Teknik Bangunan dan Landasan',   'jenjang' => 'D-3', 'tingkat' => 3],
        'OBU' => ['nama' => 'Operasi Bandar Udara',           'jenjang' => 'D-3', 'tingkat' => 3],
    ];

    protected $fillable = [
        'user_id',
        'npm',
        'nama',
        'nickname',
        'kelas',
        'jenis_kelamin',
        'prodi',
        'tingkat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poin()
    {
        return $this->hasMany(PoinMahasiswa::class);
    }

    /**
     * Nama panjang prodi, fallback ke kode kalau tidak dikenal.
     */
    public function getProdiNamaAttribute(): string
    {
        return self::PRODI[$this->prodi]['nama'] ?? $this->prodi;
    }

    public function getJenjangAttribute(): string
    {
        return self::PRODI[$this->prodi]['jenjang'] ?? '-';
    }

    /**
     * Jumlah taruna per prodi per tingkat, untuk grafik.
     * perTingkat[i] = null kalau prodi itu tidak punya tingkat tsb (D-3 tidak punya tingkat 4).
     */
    public static function chartDataPerTingkat()
    {
        $counts = self::selectRaw('prodi, tingkat, count(*) as jumlah')
            ->groupBy('prodi', 'tingkat')
            ->get()
            ->groupBy('prodi');

        return collect(self::PRODI)->map(function ($info, $kode) use ($counts) {
            $perTingkat = $counts->get($kode, collect())->pluck('jumlah', 'tingkat');

            return [
                'kode'       => $kode,
                'nama'       => $info['nama'],
                'jenjang'    => $info['jenjang'],
                'maxTingkat' => $info['tingkat'],
                'perTingkat' => collect(range(1, 4))->map(fn ($t) => $t <= $info['tingkat'] ? (int) ($perTingkat[$t] ?? 0) : null),
            ];
        })->values();
    }
}
