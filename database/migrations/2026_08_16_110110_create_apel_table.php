<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apel', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('sesi', ['pagi', 'malam', 'khusus']);

            // Kunci unik tanggal+sesi hanya untuk pagi/malam. Diisi NULL untuk apel
            // khusus — MySQL mengabaikan NULL pada unique index, sehingga apel
            // khusus boleh lebih dari satu per tanggal. Diisi otomatis di model.
            $table->string('sesi_unik', 10)->nullable();

            $table->string('nama_apel')->nullable();   // wajib untuk sesi khusus
            $table->time('jam')->nullable();
            $table->string('pembina');
            $table->foreignId('pembina_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('lokasi');
            $table->text('informasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['tanggal', 'sesi_unik']);
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apel');
    }
};
