<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Siapa yang melakukan aksi
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name');        // nama user saat log dibuat (snapshot)
            $table->string('user_role');        // role user: pengasuh | penyelenggara

            // Aksi apa yang dilakukan
            $table->string('modul');            // poin | acara | surat
            $table->string('aksi');             // tambah | hapus | ubah | buat | selesai | tolak | dll.

            // Deskripsi singkat & detail JSON
            $table->string('deskripsi');        // kalimat singkat, contoh: "Tambah poin prestasi untuk Budi (NPM: 12345)"
            $table->json('detail')->nullable(); // data tambahan: nilai, npm, nama_acara, dsb.

            // Referensi ke record asli (opsional, untuk deep-link)
            $table->string('subject_type')->nullable();  // App\Models\PoinMahasiswa
            $table->unsignedBigInteger('subject_id')->nullable();

            // IP address pencatat
            $table->string('ip_address', 45)->nullable();

            $table->timestamps(); // created_at = waktu aktivitas

            // Index untuk filter & sort cepat
            $table->index(['modul', 'aksi']);
            $table->index('user_id');
            $table->index('created_at');

            // Foreign key ke users (nullable agar log tetap ada walau user dihapus)
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
