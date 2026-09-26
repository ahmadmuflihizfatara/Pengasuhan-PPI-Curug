<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tiga pengasuh bertugas per hari.
 * - pengasuh.hari: hari tugas default (alokasi admin) — tidak unik lagi, boleh kosong.
 * - jadwal_pengasuh: satu baris per (tanggal, pengasuh), bukan satu per tanggal.
 */
return new class extends Migration
{
    private const HARI = "'senin','selasa','rabu','kamis','jumat','sabtu','minggu'";

    public function up(): void
    {
        Schema::table('pengasuh', function (Blueprint $table) {
            $table->dropUnique(['hari']);
        });
        // ponytail: raw SQL karena ->change() di Laravel 10 butuh doctrine/dbal (MySQL saja)
        DB::statement('ALTER TABLE pengasuh MODIFY hari ENUM(' . self::HARI . ') NULL');
        Schema::table('pengasuh', function (Blueprint $table) {
            $table->index('hari');
        });

        Schema::table('jadwal_pengasuh', function (Blueprint $table) {
            $table->dropUnique(['tanggal']);
            $table->unique(['tanggal', 'pengasuh_id']);
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pengasuh', function (Blueprint $table) {
            $table->dropUnique(['tanggal', 'pengasuh_id']);
            $table->unique('tanggal');
        });

        Schema::table('pengasuh', function (Blueprint $table) {
            $table->dropIndex(['hari']);
        });
        DB::statement('ALTER TABLE pengasuh MODIFY hari ENUM(' . self::HARI . ') NOT NULL');
        Schema::table('pengasuh', function (Blueprint $table) {
            $table->unique('hari');
        });
    }
};
