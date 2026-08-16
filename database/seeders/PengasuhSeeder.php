<?php

namespace Database\Seeders;

use App\Models\Pengasuh;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengasuhSeeder extends Seeder
{
    /**
     * Seed 7 akun pengasuh, satu bertugas tetap per hari (Senin—Minggu).
     * Username & password: hari (mis. "senin" / "senin@2026").
     * Idempotent — aman dijalankan ulang.
     */
    private const ROSTER = [
        'senin'  => 'Ahmad Fauzi',
        'selasa' => 'Siti Rahmawati',
        'rabu'   => 'Budi Santoso',
        'kamis'  => 'Dewi Anggraini',
        'jumat'  => 'Muhammad Iqbal',
        'sabtu'  => 'Nur Halimah',
        'minggu' => 'Rian Pratama',
    ];

    public function run(): void
    {
        $rows = [];

        foreach (self::ROSTER as $hari => $nama) {
            $email = "{$hari}@pengasuh.ppicurug.ac.id";

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $nama,
                    'username' => $hari,
                    'jabatan'  => 'Pengasuh Jaga ' . Pengasuh::HARI[$hari],
                    'role'     => User::ROLE_PENGASUH,
                    'password' => Hash::make($hari . '@2026'),
                ]
            );

            Pengasuh::updateOrCreate(
                ['hari' => $hari],
                ['user_id' => $user->id, 'nama' => $nama]
            );

            $rows[] = [Pengasuh::HARI[$hari], $nama, $email, $hari . '@2026'];
        }

        $this->command->info('✅ PengasuhSeeder selesai — 7 akun pengasuh (satu per hari):');
        $this->command->table(['Hari', 'Nama', 'Email', 'Password'], $rows);
    }
}
