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
        Schema::create('pengajuan_sk_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->index();
            $table->string('nama_mahasiswa');
            $table->string('prodi');
            $table->text('judul_skripsi');
            $table->string('path_file_syarat')->nullable();
            $table->string('no_hp');

            // Hanya ada dosen pembimbing
            $table->foreignId('pembimbing_1_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->foreignId('pembimbing_2_id')->nullable()->constrained('dosen')->nullOnDelete();

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
