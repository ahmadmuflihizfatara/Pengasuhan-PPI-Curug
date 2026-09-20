<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kasi Internal & Polisi Taruna bukan lagi role terpisah, tapi akses khusus
     * yang diberikan admin ke akun taruna tertentu. Akun lama dikonversi otomatis.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('akses_khusus')->nullable()->after('role'); // ["kasi_internal","polisi_taruna"]
        });

        foreach (['kasi_internal', 'polisi_taruna'] as $akses) {
            DB::table('users')->where('role', $akses)->update([
                'role'         => 'taruna',
                'akses_khusus' => json_encode([$akses]),
            ]);
        }
    }

    public function down(): void
    {
        foreach (['polisi_taruna', 'kasi_internal'] as $akses) {
            DB::table('users')->where('role', 'taruna')
                ->whereJsonContains('akses_khusus', $akses)
                ->update(['role' => $akses]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('akses_khusus');
        });
    }
};
