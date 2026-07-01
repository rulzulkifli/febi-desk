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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();

            // Kode unik prodi (misal: '55201', 'TI', 'SI')
            $table->string('kode_prodi', 20)->unique();

            // Nama lengkap prodi (misal: 'Teknik Informatika')
            $table->string('nama_prodi');

            // Kolom baru untuk singkatan prodi (misal: MBS, ESY, PBS)
            $table->string('singkatan', 10);

            // Jenjang pendidikan (misal: 'D3', 'S1', 'S2')
            $table->string('jenjang', 10);

            // Akreditasi dibuat nullable jika datanya belum ada (misal: 'A', 'B', 'Unggul')
            $table->string('akreditasi', 10)->nullable();

            // Opsional: Jika prodi terikat dengan fakultas, hapus komentar di bawah ini
            // $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
