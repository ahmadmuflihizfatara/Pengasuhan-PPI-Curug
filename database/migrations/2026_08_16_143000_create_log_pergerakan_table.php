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
        Schema::create('log_pergerakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->string('npm')->nullable();
            $table->string('prodi')->nullable();
            
            // Kategori utama: perizinan, ekstrakurikuler, olahraga
            $table->string('kategori');
            
            // Sub-kategori:
            // - Perizinan: Kesehatan, Berduka, Lainnya
            // - Ekstrakurikuler: Wajib, Olahraga, Seni, Akademik
            // - Olahraga: Mandiri, Terpimpin
            $table->string('subkategori');

            // 1. Cabang Perizinan
            $table->text('keterangan_keluhan')->nullable();

            // 2. Cabang Ekstrakurikuler
            $table->string('nama_ekskul')->nullable();
            $table->integer('jumlah_anggota')->default(1);
            $table->text('daftar_anggota')->nullable();
            $table->string('lokasi_kegiatan')->nullable();

            // 3. Cabang Olahraga
            $table->string('rute')->nullable();
            $table->text('pengikut')->nullable();

            // Dokumentasi & Waktu Berangkat
            $table->string('foto_keberangkatan')->nullable();
            $table->dateTime('waktu_berangkat');
            $table->dateTime('estimasi_kembali')->nullable();

            // Status: 'berangkat' (🔴 BELUM KEMBALI), 'kembali' (🟢 SUDAH KEMBALI)
            $table->string('status')->default('berangkat');

            // Dokumentasi & Waktu Kembali
            $table->dateTime('waktu_kembali')->nullable();
            $table->string('foto_kembali')->nullable();
            $table->text('catatan_kembali')->nullable();

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_pergerakan');
    }
};
