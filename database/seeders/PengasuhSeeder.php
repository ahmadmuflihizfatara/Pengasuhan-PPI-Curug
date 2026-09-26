<?php

namespace Database\Seeders;

use App\Models\Pengasuh;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengasuhSeeder extends Seeder
{
    /**
     * Seed 21 akun pengasuh — tiga bertugas default per hari (Senin—Minggu).
     * Username: hari untuk pengasuh pertama, hari+2 / hari+3 untuk berikutnya
     * (mis. "senin", "senin2", "senin3"); password: username + "@2026".
     * Idempotent — aman dijalankan ulang, dan tidak menimpa alokasi hari dari admin.
     */
    private const ROSTER = [
        'senin'  => ['Ahmad Fauzi', 'Hendra Wijaya', 'Lestari Putri'],
        'selasa' => ['Siti Rahmawati', 'Agus Setiawan', 'Maya Sari'],
        'rabu'   => ['Budi Santoso', 'Fitri Handayani', 'Yoga Pratama'],
        'kamis'  => ['Dewi Anggraini', 'Rudi Hartono', 'Intan Permata'],
        'jumat'  => ['Muhammad Iqbal', 'Sri Wahyuni', 'Dimas Saputra'],
        'sabtu'  => ['Nur Halimah', 'Eko Prasetyo', 'Rina Marlina'],
        'minggu' => ['Rian Pratama', 'Wulan Dari', 'Fajar Nugroho'],
    ];

    public function run(): void
    {
        $rows = [];

        foreach (self::ROSTER as $hari => $daftarNama) {
            foreach ($daftarNama as $i => $nama) {
                $username = $i === 0 ? $hari : $hari . ($i + 1);
                $email    = "{$username}@pengasuh.ppicurug.ac.id";

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name'     => $nama,
                        'username' => $username,
                        'jabatan'  => 'Pengasuh Jaga ' . Pengasuh::HARI[$hari],
                        'role'     => User::ROLE_PENGASUH,
                        'password' => Hash::make($username . '@2026'),
                    ]
                );

                Pengasuh::firstOrCreate(
                    ['user_id' => $user->id],
                    ['nama' => $nama, 'hari' => $hari]
                );

                $rows[] = [Pengasuh::HARI[$hari], $nama, $email, $username . '@2026'];
            }
        }

        $this->command->info('✅ PengasuhSeeder selesai — 21 akun pengasuh (tiga per hari):');
        $this->command->table(['Hari', 'Nama', 'Email', 'Password'], $rows);
    }
}
