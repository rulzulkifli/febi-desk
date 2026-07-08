<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PengajuanSkPembimbing;
use App\Models\PengajuanSkUjian;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class SkUjianController extends Controller
{
    public function create()
    {
        $dosens = Dosen::orderBy('nama_dosen', 'asc')->get();
        $prodis = ProgramStudi::orderBy('nama_prodi', 'asc')->get();
        return view('sk-ujian.create', compact('dosens', 'prodis'));
    }

    public function cekNim($nim)
    {
        $skPembimbing = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2'])
            ->where('nim', $nim)
            ->whereIn('status', ['siap_dicetak'])
            ->latest()
            ->first();

        if ($skPembimbing) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data SK Pembimbing otomatis ditemukan.',
                'data' => [
                    'nim' => $skPembimbing->nim,
                    'nama_mahasiswa' => $skPembimbing->nama_mahasiswa,
                    'judul_skripsi' => $skPembimbing->judul_skripsi,
                    'pembimbing_1_id' => $skPembimbing->pembimbing_1_id,
                    // Pastikan memanggil kolom yang benar (contoh: nama_dosen)
                    'pembimbing_1_nama' => $skPembimbing->pembimbing1->nama_dosen ?? 'Nama Tidak Ditemukan',
                    'pembimbing_2_id' => $skPembimbing->pembimbing_2_id,
                    'prodi' => $skPembimbing->prodi,
                    'pembimbing_2_nama' => $skPembimbing->pembimbing2->nama_dosen ?? 'Nama Tidak Ditemukan',
                ]
            ]);
        }

        return response()->json([
            'status' => 'not_found',
            'message' => 'Data pembimbing tidak ditemukan di sistem. Silakan gunakan jalur SK Fisik.'
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi dikurangi, tidak perlu tanggal dan waktu lagi
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string',
            'jenis_ujian' => 'required|in:proposal,hasil,skripsi',
            'judul_skripsi' => 'required|string',
        ]);

        $pembimbing1Id = $request->pembimbing_1_id;
        $pembimbing2Id = $request->pembimbing_2_id;
        $isLuarSistem = false;
        $filePath = null;

        if ($request->has_physical === 'ya') {
            $isLuarSistem = true;
            $pembimbing1Id = $request->pembimbing_1_id_manual;
            $pembimbing2Id = $request->pembimbing_2_id_manual;

            $request->validate([
                'path_sk_pembimbing_lama' => 'required|file|mimes:pdf|max:2048',
                'pembimbing_1_id_manual' => 'required',
            ]);

            if ($request->hasFile('path_sk_pembimbing_lama')) {
                $filePath = $request->file('path_sk_pembimbing_lama')->store('syarat-sk-ujian-transisi', 'public');
            }
        }

        // 2. Simpan Data ke Database
        PengajuanSkUjian::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'prodi' => $request->prodi,
            'jenis_ujian' => $request->jenis_ujian,
            'judul_skripsi' => $request->judul_skripsi,

            // --- BAGIAN OTOMATIS & ADMIN ---
            'tanggal_ujian' => null, // Dikosongkan agar diisi Admin Prodi
            'waktu_ujian' => null,   // Dikosongkan agar diisi Admin Prodi
            'ruangan_ujian' => 'Ruang Ujian Seminar Fakultas', // Hardcode otomatis
            // -------------------------------

            'pembimbing_1_id' => $pembimbing1Id,
            'pembimbing_2_id' => $pembimbing2Id,
            'sk_pembimbing_luar_sistem' => $isLuarSistem,
            'path_sk_pembimbing_lama' => $filePath,
        ]);

        return redirect()->route('sk-ujian.create')->with('success', 'Pengajuan SK Ujian Anda berhasil dikirim! Tanggal dan Waktu ujian akan ditentukan oleh Prodi.');
    }
}
