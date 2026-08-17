<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswa')->nullOnDelete();

            // Snapshot data pengaju — tetap utuh meski data mahasiswa berubah belakangan
            $table->string('email');
            $table->string('nama');
            $table->string('npm', 20)->nullable();
            $table->string('prodi', 10)->nullable();
            $table->string('tingkat', 5)->nullable();

            $table->enum('jenis', ['individu', 'kelompok'])->default('individu');
            $table->unsignedInteger('jumlah_anggota')->nullable(); // wajib untuk jenis kelompok

            $table->string('kategori', 20); // Akademik | Non-Akademik
            $table->date('tanggal_prestasi');
            $table->text('keterangan');
            $table->json('dokumen'); // wajib minimal 1 file

            $table->string('status', 20)->default('Diajukan');
            $table->text('catatan_pengasuhan')->nullable(); // mis. reward berupa barang, jajan, atau poin pengasuhan
            $table->boolean('taruna_baca')->default(true);

            $table->timestamps();

            $table->index('tanggal_prestasi');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward');
    }
};
