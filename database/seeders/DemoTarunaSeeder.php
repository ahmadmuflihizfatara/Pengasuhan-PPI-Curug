<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoTarunaSeeder extends Seeder
{
    /**
     * Data contoh untuk menguji daftar, pencarian, filter, dan dashboard taruna.
     * Akun demo menggunakan kata sandi yang sama: Taruna@2026
     */
    public function run(): void
    {
        $taruna = [
            ['npm' => '2026101001', 'nama' => 'Aditya Pratama',       'nickname' => 'Aditya', 'jenis_kelamin' => 'L', 'prodi' => 'PNB', 'tingkat' => '2'],
            ['npm' => '2026101002', 'nama' => 'Nabila Azzahra',       'nickname' => 'Nabila', 'jenis_kelamin' => 'P', 'prodi' => 'LLU', 'tingkat' => '1'],
            ['npm' => '2026101003', 'nama' => 'Raka Mahendra',        'nickname' => 'Raka',   'jenis_kelamin' => 'L', 'prodi' => 'TPU', 'tingkat' => '3'],
            ['npm' => '2026101004', 'nama' => 'Salsabila Putri',      'nickname' => 'Salsa',  'jenis_kelamin' => 'P', 'prodi' => 'PA',  'tingkat' => '2'],
            ['npm' => '2026101005', 'nama' => 'Fajar Ramadhan',       'nickname' => 'Fajar',  'jenis_kelamin' => 'L', 'prodi' => 'TLB', 'tingkat' => '1'],
            ['npm' => '2026101006', 'nama' => 'Citra Lestari',        'nickname' => 'Citra',  'jenis_kelamin' => 'P', 'prodi' => 'PKP', 'tingkat' => '3'],
            ['npm' => '2026101007', 'nama' => 'Bagas Saputra',        'nickname' => 'Bagas',  'jenis_kelamin' => 'L', 'prodi' => 'TMB', 'tingkat' => '2'],
            ['npm' => '2026101008', 'nama' => 'Keisya Anindita',      'nickname' => 'Keisya', 'jenis_kelamin' => 'P', 'prodi' => 'TBL', 'tingkat' => '1'],
            ['npm' => '2026101009', 'nama' => 'Dimas Arya Nugraha',   'nickname' => 'Dimas',  'jenis_kelamin' => 'L', 'prodi' => 'OBU', 'tingkat' => '3'],
            ['npm' => '2026101010', 'nama' => 'Aulia Rahmawati',      'nickname' => 'Aulia',  'jenis_kelamin' => 'P', 'prodi' => 'PNB', 'tingkat' => '4'],
        ];

        foreach ($taruna as $data) {
            $username = strtolower($data['nickname']);
            $email = $username . '.' . $data['npm'] . '@student.ppicurug.ac.id';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $data['nama'],
                    'username' => $username,
                    'nama_panggilan' => $data['nickname'],
                    'password' => Hash::make('Taruna@2026'),
                    'jabatan' => 'Taruna ' . $data['prodi'] . ' Tingkat ' . $data['tingkat'],
                    'prodi' => $data['prodi'],
                    'role' => User::ROLE_TARUNA,
                ],
            );

            Mahasiswa::updateOrCreate(
                ['npm' => $data['npm']],
                [
                    'user_id' => $user->id,
                    'nama' => $data['nama'],
                    'nickname' => $data['nickname'],
                    'kelas' => $data['prodi'] . '-' . $data['tingkat'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'prodi' => $data['prodi'],
                    'tingkat' => $data['tingkat'],
                ],
            );
        }
    }
}
