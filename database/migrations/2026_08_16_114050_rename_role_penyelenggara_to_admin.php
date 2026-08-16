<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'penyelenggara')->update(['role' => 'admin']);
        DB::table('activity_logs')->where('user_role', 'penyelenggara')->update(['user_role' => 'admin']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'penyelenggara']);
        DB::table('activity_logs')->where('user_role', 'admin')->update(['user_role' => 'penyelenggara']);
    }
};
