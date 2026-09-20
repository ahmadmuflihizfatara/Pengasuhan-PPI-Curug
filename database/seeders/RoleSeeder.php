<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Seed akun default untuk setiap role.
     * Password: role@12345 (sesuaikan setelah production)
     */
    public function run(): void
    {
        // Admin (super admin)
        User::firstOrCreate(
            ['email' => 'admin@poltekssn.ac.id'],
            [
                'name'     => 'Admin',
                'username' => 'admin',
                'jabatan'  => 'Admin Pengasuhan',
                'role'     => User::ROLE_ADMIN,
                'password' => Hash::make('admin@12345'),
            ]
        );

        // Pengasuh
        User::firstOrCreate(
            ['email' => 'pengasuh@poltekssn.ac.id'],
            [
                'name'     => 'Pengasuh',
                'username' => 'pengasuh',
                'jabatan'  => 'Pengasuh',
                'role'     => User::ROLE_PENGASUH,
                'password' => Hash::make('pengasuh@12345'),
            ]
        );

        // Taruna (contoh)
        User::firstOrCreate(
            ['email' => 'taruna@poltekssn.ac.id'],
            [
                'name'     => 'Taruna Demo',
                'username' => 'taruna',
                'jabatan'  => 'Taruna',
                'role'     => User::ROLE_TARUNA,
                'password' => Hash::make('taruna@12345'),
            ]
        );

        // Taruna dengan akses khusus Kepala Seksi Internal (membuat jadwal duty)
        User::firstOrCreate(
            ['email' => 'kasi.internal@poltekssn.ac.id'],
            [
                'name'     => 'Kasi Internal Demo',
                'username' => 'kasi_internal',
                'jabatan'  => 'Kepala Seksi Internal',
                'role'     => User::ROLE_TARUNA,
                'akses_khusus' => [User::AKSES_KASI_INTERNAL],
                'password' => Hash::make('kasi@12345'),
            ]
        );

        // Taruna dengan akses khusus Polisi Taruna (memberi pelanggaran/pengurangan poin)
        User::firstOrCreate(
            ['email' => 'polisi.taruna@poltekssn.ac.id'],
            [
                'name'     => 'Polisi Taruna Demo',
                'username' => 'polisi_taruna',
                'jabatan'  => 'Polisi Taruna',
                'role'     => User::ROLE_TARUNA,
                'akses_khusus' => [User::AKSES_POLISI_TARUNA],
                'password' => Hash::make('polisi@12345'),
            ]
        );

        $this->command->info('✅ Role seeder selesai:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',                 'admin@poltekssn.ac.id',        'admin@12345'],
                ['Pengasuh',              'pengasuh@poltekssn.ac.id',     'pengasuh@12345'],
                ['Taruna',                'taruna@poltekssn.ac.id',       'taruna@12345'],
                ['Taruna + Kasi Internal', 'kasi.internal@poltekssn.ac.id', 'kasi@12345'],
                ['Taruna + Polisi Taruna', 'polisi.taruna@poltekssn.ac.id', 'polisi@12345'],
            ]
        );
    }
}
