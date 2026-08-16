<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Reset seluruh data mahasiswa + akun taruna yang terhubung,
     * lalu isi ulang dengan 5 mahasiswa per prodi per tingkat.
     *
     * Menghapus baris mahasiswa ikut menghapus poin miliknya (FK cascade).
     * Akun taruna yang tidak terhubung ke baris mahasiswa tidak disentuh.
     */
    public function run(): void
    {
        $userIds = Mahasiswa::whereNotNull('user_id')->pluck('user_id');

        $mahasiswaDihapus = Mahasiswa::count();
        Mahasiswa::query()->delete();          // poin ikut terhapus via cascade
        $akunDihapus = User::whereIn('id', $userIds)->delete();

        $this->command->warn("🗑️  Dihapus: {$mahasiswaDihapus} mahasiswa, {$akunDihapus} akun taruna.");

        $dibuat = 0;
        $i      = 0;

        foreach (array_keys(Mahasiswa::PRODI) as $urut => $kode) {
            $maxTingkat = Mahasiswa::PRODI[$kode]['tingkat'];

            for ($tingkat = 1; $tingkat <= $maxTingkat; $tingkat++) {
                // Tingkat 1 = angkatan termuda. 2026 - (tingkat - 1)
                $angkatan = (int) date('Y') - ($tingkat - 1);

                for ($n = 1; $n <= 5; $n++) {
                    $isLaki = ($i % 5) < 3;
                    $depan  = $isLaki
                        ? self::NAMA_LAKI[$i % count(self::NAMA_LAKI)]
                        : self::NAMA_PEREMPUAN[$i % count(self::NAMA_PEREMPUAN)];
                    $belakang = self::NAMA_BELAKANG[($i * 7) % count(self::NAMA_BELAKANG)];

                    Mahasiswa::create([
                        'npm'           => sprintf('%d%02d%03d', $angkatan, $urut + 1, $n),
                        'nama'          => $depan . ' ' . $belakang,
                        'nickname'      => $depan,
                        'kelas'         => $tingkat . ' ' . $kode,
                        'jenis_kelamin' => $isLaki ? 'L' : 'P',
                        'prodi'         => $kode,
                        'tingkat'       => (string) $tingkat,
                    ]);

                    $dibuat++;
                    $i++;
                }
            }
        }

        $this->command->info("✅ Dibuat: {$dibuat} mahasiswa baru.");

        // Buat akun untuk mahasiswa yang belum punya user
        $this->call(TarunaSeeder::class);
    }

    private const NAMA_LAKI = [
        'Adit', 'Bagas', 'Candra', 'Dimas', 'Eko', 'Fajar', 'Galih', 'Hendra',
        'Irfan', 'Joko', 'Krisna', 'Luthfi', 'Mahendra', 'Naufal', 'Oscar',
        'Pandu', 'Rafi', 'Satria', 'Taufik', 'Umar', 'Vito', 'Wisnu', 'Yoga',
        'Zaki', 'Arya', 'Bayu', 'Cahyo', 'Damar', 'Erlangga', 'Farhan',
        'Gilang', 'Hafiz', 'Ilham', 'Jefri', 'Kevin', 'Lukman', 'Mikail',
        'Nanda', 'Okta', 'Prasetyo', 'Reza', 'Sandi', 'Tirta', 'Utomo',
        'Verrel', 'Wahyu', 'Yusuf', 'Zulfikar', 'Aksa', 'Bimo',
    ];

    private const NAMA_PEREMPUAN = [
        'Anisa', 'Bunga', 'Citra', 'Dewi', 'Elsa', 'Fitri', 'Gita', 'Hana',
        'Indah', 'Jihan', 'Kirana', 'Laras', 'Maharani', 'Nadia', 'Olivia',
        'Putri', 'Rania', 'Salma', 'Tiara', 'Ulfa', 'Vania', 'Wulan',
        'Yasmin', 'Zahra', 'Alika', 'Bella', 'Cindy', 'Dinda', 'Elvira',
        'Farah', 'Ghina', 'Hilda', 'Intan', 'Jelita', 'Kamila', 'Lita',
        'Mutiara', 'Nabila', 'Oktavia', 'Prita',
    ];

    private const NAMA_BELAKANG = [
        'Pratama', 'Wijaya', 'Nugroho', 'Saputra', 'Hidayat', 'Ramadhan',
        'Kusuma', 'Santoso', 'Firmansyah', 'Maulana', 'Setiawan', 'Anggara',
        'Baskoro', 'Cahyono', 'Dharmawan', 'Effendi', 'Gunawan', 'Halim',
        'Iskandar', 'Jatmiko', 'Kurniawan', 'Lesmana', 'Mahardika', 'Nashir',
        'Purnama', 'Sudirman', 'Tanjung', 'Utama', 'Wibowo', 'Yudhistira',
        'Zulkarnain', 'Sinaga', 'Nasution', 'Simamora', 'Tampubolon',
        'Situmorang', 'Panjaitan', 'Hutapea', 'Siregar', 'Marbun', 'Ginting',
        'Sembiring', 'Lubis', 'Harahap', 'Batubara', 'Manullang', 'Silalahi',
    ];
}
