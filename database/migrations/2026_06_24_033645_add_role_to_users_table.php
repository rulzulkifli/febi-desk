<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan role dengan istilah lokal kampus
            $table->enum('peran', ['admin_prodi', 'wadek_1'])->default('admin_prodi')->after('password');
            $table->string('akses_prodi')->nullable()->after('peran'); // Contoh: 'Ekonomi Syariah' atau 'Perbankan Syariah'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['peran', 'akses_prodi']);
        });
    }
};
