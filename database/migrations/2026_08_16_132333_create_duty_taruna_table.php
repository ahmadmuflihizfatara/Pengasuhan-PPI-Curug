<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duty_taruna', function (Blueprint $table) {
            $table->id();
            // Tanggal Senin dari minggu bersangkutan — kunci satu periode duty
            $table->date('minggu_mulai');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->foreignId('diinput_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Satu taruna hanya sekali per minggu
            $table->unique(['minggu_mulai', 'mahasiswa_id']);
            $table->index('minggu_mulai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duty_taruna');
    }
};
