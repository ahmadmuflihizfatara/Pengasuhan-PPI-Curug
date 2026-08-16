<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluhan_barak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email');
            $table->string('nama');
            $table->date('tanggal_pengajuan');
            $table->string('prodi', 10);
            $table->string('asrama', 50);
            $table->string('lorong', 50);
            $table->string('nomor_barak', 20);
            $table->text('keterangan');
            $table->string('status', 20)->default('Diajukan');
            $table->text('catatan_pengasuhan')->nullable();
            $table->boolean('taruna_baca')->default(false);
            $table->json('lampiran')->nullable();
            $table->timestamps();

            $table->index('tanggal_pengajuan');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluhan_barak');
    }
};
