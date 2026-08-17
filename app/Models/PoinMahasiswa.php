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

    /**
     * Hitung Status Sanksi berdasarkan Total Poin Pelanggaran murni
     */
    public static function getStatusSanksi(float $totalPelanggaran): array
    {
        if ($totalPelanggaran >= 100) {
            return [
                'status'     => 'SP 3 & Rekomendasi Sidang',
                'level'      => 'sp3',
                'color'      => '#991b1b',
                'bg'         => '#fee2e2',
                'border'     => '#f87171',
                'icon'       => 'fas fa-gavel',
                'desc'       => 'Akumulasi pelanggaran mencapai batas kritis. Taruna direkomendasikan untuk Sidang Dewan Kehormatan Taruna.',
            ];
        } elseif ($totalPelanggaran >= 75) {
            return [
                'status'     => 'SP 2',
                'level'      => 'sp2',
                'color'      => '#c2410c',
                'bg'         => '#ffedd5',
                'border'     => '#fb923c',
                'icon'       => 'fas fa-exclamation-circle',
                'desc'       => 'Akumulasi pelanggaran mencapai 75-99 poin. Diterbitkan Surat Peringatan 2 (SP 2).',
            ];
        } elseif ($totalPelanggaran >= 50) {
            return [
                'status'     => 'SP 1',
                'level'      => 'sp1',
                'color'      => '#b45309',
                'bg'         => '#fef3c7',
                'border'     => '#fcd34d',
                'icon'       => 'fas fa-exclamation-triangle',
                'desc'       => 'Akumulasi pelanggaran mencapai 50-74 poin. Diterbitkan Surat Peringatan 1 (SP 1).',
            ];
        }

        return [
            'status'     => 'Status Aman',
            'level'      => 'aman',
            'color'      => '#15803d',
            'bg'         => '#dcfce7',
            'border'     => '#86efac',
            'icon'       => 'fas fa-shield-check',
            'desc'       => 'Poin pelanggaran di bawah 50 poin. Kedisiplinan taruna terpantau dalam kondisi baik.',
        ];
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
