<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            // ID user Taruna yang mengajukan (null = diinput langsung oleh pengasuh)
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // Nama pengirim asli (untuk Taruna auto-fill dari nama akun)
            $table->string('diajukan_oleh')->nullable()->after('user_id');
            // Catatan balasan dari pengasuhan (alasan ditolak atau disetujui)
            $table->text('catatan_pengasuhan')->nullable()->after('keterangan');
            // Tandai apakah taruna sudah baca notifikasi status
            $table->boolean('taruna_baca')->default(false)->after('catatan_pengasuhan');
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'diajukan_oleh', 'catatan_pengasuhan', 'taruna_baca']);
        });
    }
};
