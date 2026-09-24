<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinMahasiswa extends Model
{
    protected $table = 'poin_mahasiswa';

    const STATUS_MENUNGGU = 'menunggu_validasi';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK   = 'ditolak';

    const KAT_PRESTASI    = 'prestasi';
    const KAT_PELANGGARAN = 'pelanggaran';

    // Bobot standar pelanggaran PTTT
    const BOBOT_RINGAN = 5;
    const BOBOT_SEDANG = 20;
    const BOBOT_BERAT  = 50;

    protected $fillable = [
        'mahasiswa_id',
        'npm',
        'nama_mahasiswa',
        'kelas',
        'kategori',
        'tingkat',
        'kegiatan',
        'tanggal',
        'nilai',
        'status_validasi',
        'pengasuh',
        'diajukan_oleh_id',
        'divalidasi_oleh_id',
        'waktu_validasi',
        'catatan_validasi',
        'foto_bukti',
        'keterangan',
    ];

    protected $casts = [
        'tanggal'        => 'date',
        'waktu_validasi' => 'datetime',
        'nilai'          => 'float',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'diajukan_oleh_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh_id');
    }

    public function isApproved(): bool
    {
        return $this->status_validasi === self::STATUS_DISETUJUI || empty($this->status_validasi);
    }

    public function isPending(): bool
    {
        return $this->status_validasi === self::STATUS_MENUNGGU;
    }

    public function isRejected(): bool
    {
        return $this->status_validasi === self::STATUS_DITOLAK;
    }

    /** Poin total awal setiap taruna. Poin total = POIN_AWAL + penghargaan − pelanggaran. */
    const POIN_AWAL = 65;

    /**
     * Tingkat sanksi berdasarkan poin total, dari terberat ke teringan.
     * 'atas' = poin total tertinggi yang masih masuk tingkat itu (null = tanpa batas atas).
     * Setara aturan lama (SP 1 di 50 pelanggaran, SP 2 di 75, SP 3 di 100) dengan titik awal 65.
     */
    const TINGKAT_SANKSI = [
        'sp3'  => ['label' => 'Surat Peringatan 3 & Sidang', 'bawah' => null, 'atas' => -35],
        'sp2'  => ['label' => 'Surat Peringatan 2',          'bawah' => -34,  'atas' => -10],
        'sp1'  => ['label' => 'Surat Peringatan 1',          'bawah' => -9,   'atas' => 15],
        'aman' => ['label' => 'Aman',                        'bawah' => 16,   'atas' => null],
    ];

    public static function hitungPoinTotal(float $totalPelanggaran, float $totalPenghargaan): float
    {
        return self::POIN_AWAL + $totalPenghargaan - $totalPelanggaran;
    }

    /**
     * Status sanksi berdasarkan poin total (makin kecil makin berat).
     */
    public static function getStatusSanksi(float $poinTotal): array
    {
        $level = collect(self::TINGKAT_SANKSI)
            ->search(fn ($t) => $t['atas'] !== null && $poinTotal <= $t['atas']) ?: 'aman';

        return match ($level) {
            'sp3' => [
                'status'     => 'SP 3 & Rekomendasi Sidang',
                'level'      => 'sp3',
                'color'      => '#991b1b',
                'bg'         => '#fee2e2',
                'border'     => '#f87171',
                'icon'       => 'fas fa-gavel',
                'desc'       => 'Poin total mencapai −35 atau kurang. Taruna direkomendasikan untuk Sidang Dewan Kehormatan Taruna.',
            ],
            'sp2' => [
                'status'     => 'SP 2',
                'level'      => 'sp2',
                'color'      => '#c2410c',
                'bg'         => '#ffedd5',
                'border'     => '#fb923c',
                'icon'       => 'fas fa-exclamation-circle',
                'desc'       => 'Poin total berada di −34 s/d −10. Diterbitkan Surat Peringatan 2 (SP 2).',
            ],
            'sp1' => [
                'status'     => 'SP 1',
                'level'      => 'sp1',
                'color'      => '#b45309',
                'bg'         => '#fef3c7',
                'border'     => '#fcd34d',
                'icon'       => 'fas fa-exclamation-triangle',
                'desc'       => 'Poin total berada di −9 s/d 15. Diterbitkan Surat Peringatan 1 (SP 1).',
            ],
            default => [
                'status'     => 'Status Aman',
                'level'      => 'aman',
                'color'      => '#15803d',
                'bg'         => '#dcfce7',
                'border'     => '#86efac',
                'icon'       => 'fa-solid fa-shield-halved',
                'desc'       => 'Poin total di atas 15. Kedisiplinan taruna terpantau dalam kondisi baik.',
            ],
        };
    }

    /**
     * Master Data PTTT Pelanggaran (Peraturan Tata Tertib Taruna PPI Curug)
     */
    public static function getMasterPelanggaran(): array
    {
        return [
            'ringan' => [
                'bobot' => 5,
                'label' => 'Ringan (5 Poin)',
                'items' => [
                    'Atribut seragam tidak lengkap / tidak sesuai ketentuan dinas',
                    'Terlambat apel / dinas jaga / kegiatan dinas (< 15 menit)',
                    'Kerapian barak / tempat tidur / loker tidak standar',
                    'Tidak memakai papan nama / badge / pin taruna',
                    'Menggunakan sandal / pakaian non-standar di area terlarang',
                    'Berbicara tidak sopan / melanggar etika dasar taruna',
                    'Meninggalkan barak tanpa lapor perwira jaga',
                    'Kuku / rambut tidak rapi sesuai ketentuan dinas',
                ]
            ],
            'sedang' => [
                'bobot' => 20,
                'label' => 'Sedang (20 Poin)',
                'items' => [
                    'Keluar asrama / kampus tanpa izin dinas (Pesiar Liar / Overstay)',
                    'Merokok atau vaping di lingkungan kampus & asrama',
                    'Meninggalkan pos dinas jaga / tertidur saat dinas jaga',
                    'Membawa barang terlarang (elektronik non-izin, pemanas, dll)',
                    'Tidak mengikuti kegiatan dinas / apel tanpa keterangan (Alpa)',
                    'Melakukan tindakan indisipliner beregu / menghasut',
                    'Mengendarai kendaraan bermotor di kampus tanpa izin dinas',
                    'Menggunakan HP pada jam dinas / jam wajib belajar',
                ]
            ],
            'berat' => [
                'bobot' => 50,
                'label' => 'Berat (50 Poin)',
                'items' => [
                    'Tindak kekerasan fisik / pemukulan / perpeloncoan / bullying',
                    'Tindakan asusila / pelecehan dalam bentuk apapun',
                    'Pencurian atau perusakan fasilitas kampus / asrama',
                    'Mengonsumsi, membawa, atau mengedarkan miras / narkoba',
                    'Memalsukan tanda tangan pengasuh / pejabat / stempel dinas',
                    'Terlibat perjudian atau tindak pidana hukum',
                    'Melakukan penipuan / pemerasan terhadap sesama taruna',
                    'Membawa orang luar tanpa izin ke dalam barak / asrama',
                ]
            ],
        ];
    }

    /**
     * Master Data PTTT Penghargaan / Prestasi
     */
    public static function getMasterPenghargaan(): array
    {
        return [
            'internasional' => [
                'bobot' => 50,
                'label' => 'Tingkat Internasional (+50 Poin)',
                'items' => [
                    'Juara / Delegasi Kompetisi Internasional',
                    'Publikasi Ilmiah Jurnal Internasional Terindeks',
                    'Penghargaan Khusus Lembaga Internasional Aviation',
                ]
            ],
            'nasional' => [
                'bobot' => 30,
                'label' => 'Tingkat Nasional (+30 Poin)',
                'items' => [
                    'Juara 1 / 2 / 3 Lomba Tingkat Nasional',
                    'Peraih Medali POMNAS / Kejuaraan Nasional Kedinasan',
                    'Karya Inovasi Teknologi Penerbangan Nasional',
                ]
            ],
            'provinsi' => [
                'bobot' => 20,
                'label' => 'Tingkat Provinsi / Daerah (+20 Poin)',
                'items' => [
                    'Juara Lomba Akademik / Olahraga / Seni Tingkat Provinsi',
                    'Kontingen Daerah dalam Acara Kedinasan Resmi',
                ]
            ],
            'internal' => [
                'bobot' => 10,
                'label' => 'Internal Kampus PPI Curug (+10 Poin)',
                'items' => [
                    'Juara Lomba / Kompetisi Internal Dies Natalis',
                    'IPK Tertinggi Semester / Prestasi Akademik',
                    'Juara Cabor / Seni Internal PPI Curug',
                ]
            ],
            'keteladanan' => [
                'bobot' => 15,
                'label' => 'Keteladanan & Kepemimpinan (+15 Poin)',
                'items' => [
                    'Taruna Teladan / Disiplin Terbaik Bulanan',
                    'Penghargaan Khusus Tindakan Heroik / Kejujuran Luar Biasa',
                    'Komandan Resimen / Komandan Batalyon Berprestasi',
                ]
            ],
            'khusus' => [
                'bobot' => 10,
                'label' => 'Penugasan & Kontribusi Khusus (+10 Poin)',
                'items' => [
                    'Petugas Upacara Hari Besar Nasional / Parade Senja',
                    'Tim Marching Band Gita Swara Buana Penugasan Luar',
                    'Kontributor Aktif Pengabdian Masyarakat Pengasuhan',
                ]
            ],
        ];
    }
}
