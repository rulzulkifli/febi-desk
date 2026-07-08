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
        Schema::create('pengajuan_sk_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->index();
            $table->string('nama_mahasiswa');
            $table->string('prodi');
            $table->enum('jenis_ujian', ['proposal', 'hasil', 'skripsi']);
            $table->text('judul_skripsi');
            $table->string('no_hp');
            // Data Waktu & Tempat Ujian
            $table->date('tanggal_ujian')->nullable();
            $table->string('waktu_ujian')->nullable();
            $table->string('ruangan_ujian')->nullable();

            // Dosen Pembimbing (Tetap dicatat sebagai acuan/bisa diinput manual bagi mahasiswa lama)
            $table->foreignId('pembimbing_1_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->foreignId('pembimbing_2_id')->nullable()->constrained('dosen')->nullOnDelete();

            // Formasi Penguji (Sifatnya nullable karena diplot oleh prodi/wadek)
            $table->foreignId('ketua_penguji_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->foreignId('sekretaris_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->foreignId('anggota_1_id')->nullable()->constrained('dosen')->nullOnDelete(); // Anggota (Proposal) / Anggota I (Hasil & Skripsi)
            $table->foreignId('anggota_2_id')->nullable()->constrained('dosen')->nullOnDelete(); // Hanya untuk Hasil & Skripsi (Nullable untuk Proposal)

            // Flag Mahasiswa Transisi / Luar Sistem
            $table->boolean('sk_pembimbing_luar_sistem')->default(false);
            $table->string('path_sk_pembimbing_lama')->nullable(); // Bukti upload SK Pembimbing fisik lama jika bernilai true

            $table->enum('status', ['diajukan', 'dicek_prodi', 'persetujuan_wadek', 'siap_dicetak', 'selesai'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
