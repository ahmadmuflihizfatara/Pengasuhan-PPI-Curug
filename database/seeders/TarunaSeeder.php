<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TarunaSeeder extends Seeder
{
    /**
     * Generate akun untuk baris mahasiswa yang belum punya user_id.
     * Username : nickname (lowercase), ditambah 3 digit NPM bila sudah dipakai
     * Password : username + '.' + 3 digit terakhir NPM  (contoh: "bagas.003")
     * Email    : namadepan.namabelakang@student.ppicurug.ac.id
     */
    public function run(): void
    {
        $created = 0;
        $rows    = [];

        Mahasiswa::whereNull('user_id')->get()->each(function (Mahasiswa $m) use (&$created, &$rows) {
            $last3 = substr($m->npm ?? '', -3);
            $base  = strtolower($m->nickname ?: $m->npm);
            $kode  = strtolower($m->prodi ?? '');

            // Nickname bisa sama antar prodi — bedakan pakai kode prodi, lalu tingkat, lalu NPM
            $username = $this->firstAvailable(
                [$base, "{$base}.{$kode}", "{$base}.{$kode}{$m->tingkat}", $base . $m->npm],
                fn ($v) => User::where('username', $v)->exists()
            );
            $password = $username . '.' . $last3;
            $email    = $this->makeEmail($m->nama, $m->npm);

            $user = User::create([
                'name'           => $m->nama,
                'username'       => $username,
                'nama_panggilan' => $m->nickname,
                'email'          => $email,
                'password'       => Hash::make($password),
                'jabatan'        => 'Taruna ' . $m->kelas,
                'role'           => User::ROLE_TARUNA,
            ]);

            $m->update(['user_id' => $user->id]);

            $rows[] = [$m->nickname, $email, $password, $m->kelas];
            $created++;
        });

        $this->command->info("✅ TarunaSeeder selesai: {$created} akun dibuat untuk mahasiswa yang belum punya user.");
        if ($rows) {
            $this->command->table(['Nickname', 'Email', 'Password', 'Kelas'], $rows);
        }
    }

    private function makeEmail(string $nama, string $npm): string
    {
        $parts  = explode(' ', trim($nama));
        $first  = strtolower($parts[0]);
        $second = isset($parts[1]) ? strtolower($parts[1]) : '';
        $lokal  = $second ? "{$first}.{$second}" : $first;

        // NPM unik, jadi kandidat terakhir selalu tersedia
        $lokal = $this->firstAvailable(
            [$lokal, "{$lokal}.{$npm}"],
            fn ($v) => User::where('email', $v . '@student.ppicurug.ac.id')->exists()
        );

        return $lokal . '@student.ppicurug.ac.id';
    }

    /**
     * Kandidat pertama yang belum terpakai. Kandidat terakhir dipakai sebagai
     * cadangan terakhir meski bentrok (tidak akan terjadi: mengandung NPM).
     */
    private function firstAvailable(array $kandidat, callable $terpakai): string
    {
        foreach ($kandidat as $v) {
            if (!$terpakai($v)) {
                return $v;
            }
        }

        return end($kandidat);
    }
}
