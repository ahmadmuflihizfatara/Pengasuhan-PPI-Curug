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
        Schema::table('log_pergerakan', function (Blueprint $table) {
            // Validasi audit oleh pengasuh/admin atas log yang diinput mandiri oleh taruna
            $table->boolean('is_validated')->default(false)->after('verified_by');
            $table->unsignedBigInteger('validated_by')->nullable()->after('is_validated');
            $table->dateTime('validated_at')->nullable()->after('validated_by');

            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_pergerakan', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['is_validated', 'validated_by', 'validated_at']);
        });
    }
};
