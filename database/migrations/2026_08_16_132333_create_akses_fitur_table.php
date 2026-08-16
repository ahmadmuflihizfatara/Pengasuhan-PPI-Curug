<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akses_fitur', function (Blueprint $table) {
            $table->id();
            $table->string('fitur')->unique();   // jadwal_pengasuh | duty_taruna | apel
            $table->boolean('diizinkan')->default(true);
            $table->foreignId('diubah_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akses_fitur');
    }
};
