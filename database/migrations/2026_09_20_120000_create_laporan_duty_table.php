<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Laporan taruna sakit harian dari taruna yang sedang duty ke pengasuh */
    public function up(): void
    {
        Schema::create('laporan_duty', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete(); // taruna yang sakit
            $table->text('keterangan')->nullable();                                        // keluhan / kondisi
            $table->foreignId('dilaporkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Satu taruna sakit dicatat sekali per hari — lapor ulang = perbarui keterangan
            $table->unique(['tanggal', 'mahasiswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_duty');
    }
};
