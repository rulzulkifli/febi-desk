<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSkPembimbing;
use App\Models\ProgramStudi; // <- Jangan lupa import model ProgramStudi

class SkPembimbingController extends Controller
{
    public function create()
    {
        // Ambil semua data prodi dari database
        $prodis = ProgramStudi::orderBy('nama_prodi', 'asc')->get();

        // Lempar variabel $prodis ke view
        return view('sk-pembimbing.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input form secara ketat (Ubah validasi prodi mengecek ID)
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|exists:program_studi,id', // <- Pastikan ID prodi valid di tabel program_studi
            'judul_skripsi' => 'required|string',
            'no_hp' => 'required|string',
            'path_file_syarat' => 'required|file|mimes:pdf|max:2048', // Maksimal PDF 2MB (Saya revisi max:2048 agar sesuai ukuran KB di Laravel)
        ], [
            'path_file_syarat.max' => 'Ukuran berkas persyaratan tidak boleh melebihi 2 Megabytes (MB).',
            'path_file_syarat.mimes' => 'Berkas persyaratan wajib berformat PDF.',
            'prodi.exists' => 'Program studi yang dipilih tidak valid.'
        ]);

        // 2. Proses upload file ke folder storage
        $filePath = null;
        if ($request->hasFile('path_file_syarat')) {
            $filePath = $request->file('path_file_syarat')->store('syarat-sk-pembimbing', 'public');
        }

        // 3. Simpan data ke database (Nilai $request->prodi sekarang berisi ID)
        PengajuanSkPembimbing::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'prodi' => $request->prodi, // Ini akan otomatis menyimpan ID prodi
            'judul_skripsi' => $request->judul_skripsi,
            'no_hp' => $request->no_hp,
            'path_file_syarat' => $filePath,
        ]);

        // 4. Kembali ke halaman form dengan notifikasi sukses
        return redirect()->route('sk-pembimbing.create')->with('success', 'Pengajuan SK Pembimbing Anda berhasil dikirim! Silakan pantau status pengajuan Anda secara berkala.');
    }
}
