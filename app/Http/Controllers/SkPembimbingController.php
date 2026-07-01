<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSkPembimbing;

class SkPembimbingController extends Controller
{
    public function create()
    {
        return view('sk-pembimbing.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi input form secara ketat
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string',
            'judul_skripsi' => 'required|string',
            'path_file_syarat' => 'required|file|mimes:pdf|max:200', // Maksimal PDF 2MB
        ], [
            'path_file_syarat.max' => 'Ukuran berkas persyaratan tidak boleh melebihi 2 Megabytes (MB).',
            'path_file_syarat.mimes' => 'Berkas persyaratan wajib berformat PDF.',
        ]);

        // 2. Proses upload file ke folder storage/app/private/syarat-sk-pembimbing (Aman di Laravel 13)
        $filePath = null;
        if ($request->hasFile('path_file_syarat')) {
            $filePath = $request->file('path_file_syarat')->store('syarat-sk-pembimbing', 'public');
        }

        // 3. Simpan data ke database (Status default otomatis 'diajukan' sesuai cetakan migration)
        PengajuanSkPembimbing::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'prodi' => $request->prodi,
            'judul_skripsi' => $request->judul_skripsi,
            'path_file_syarat' => $filePath,
        ]);

        // 4. Kembali ke halaman form dengan notifikasi sukses yang elegan
        return redirect()->route('sk-pembimbing.create')->with('success', 'Pengajuan SK Pembimbing Anda berhasil dikirim! Silakan pantau status pengajuan Anda secara berkala.');
    }
}
