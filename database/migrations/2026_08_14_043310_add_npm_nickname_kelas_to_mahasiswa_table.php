<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('npm', 20)->nullable()->unique()->after('user_id');
            $table->string('nickname')->nullable()->after('nama');
            $table->string('kelas')->nullable()->after('nickname');
        });

        // jenis_kelamin belum tersedia di data lama, longgarkan jadi nullable
        DB::statement("ALTER TABLE mahasiswa MODIFY jenis_kelamin ENUM('L','P') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['npm', 'nickname', 'kelas']);
        });

        DB::statement("ALTER TABLE mahasiswa MODIFY jenis_kelamin ENUM('L','P') NOT NULL");
    }
};
