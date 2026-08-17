<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('poin_mahasiswa', function (Blueprint $table) {
            // Tingkat pelanggaran / kategori penghargaan sesuai PTTT
            $table->string('tingkat')->nullable()->after('kategori'); // 'ringan' (5), 'sedang' (20), 'berat' (50), atau tingkat prestasi
            
            // Workflow Validasi Pengasuh -> Admin Pusbangkar
            $table->string('status_validasi')->default('disetujui')->after('nilai'); // 'menunggu_validasi', 'disetujui', 'ditolak'
            $table->unsignedBigInteger('diajukan_oleh_id')->nullable()->after('pengasuh');
            $table->unsignedBigInteger('divalidasi_oleh_id')->nullable()->after('diajukan_oleh_id');
            $table->dateTime('waktu_validasi')->nullable()->after('divalidasi_oleh_id');
            $table->text('catatan_validasi')->nullable()->after('waktu_validasi');
            $table->string('foto_bukti')->nullable()->after('catatan_validasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poin_mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'tingkat',
                'status_validasi',
                'diajukan_oleh_id',
                'divalidasi_oleh_id',
                'waktu_validasi',
                'catatan_validasi',
                'foto_bukti',
            ]);
        });
    }
};
