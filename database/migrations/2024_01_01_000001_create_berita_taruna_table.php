<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_taruna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['pengumuman', 'prestasi', 'kegiatan', 'informasi', 'lainnya'])->default('informasi');
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('gambar')->nullable();       // path gambar sampul
            $table->boolean('is_published')->default(true);
            $table->boolean('is_pinned')->default(false);  // berita dipinned
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_taruna');
    }
};
