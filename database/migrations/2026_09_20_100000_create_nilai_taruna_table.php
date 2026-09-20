<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_taruna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->unsignedTinyInteger('semester');          // 1..8
            $table->decimal('ips', 3, 2);                     // Indeks Prestasi Semester 0.00-4.00
            $table->decimal('samapta', 5, 2);                 // 0-100
            $table->decimal('pengasuhan', 5, 2);              // 0-100
            $table->text('keterangan')->nullable();
            $table->foreignId('diinput_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_taruna');
    }
};
