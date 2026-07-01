<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSkPembimbing;

class SkUjianController extends Controller
{
    public function create()
    {
        return view('sk-ujian.create');
    }

    public function cekNim($nim)
    {
        // Cek otomatis ke tabel SK Pembimbing yang sudah berstatus selesai 
        $skPembimbing = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2'])
            ->where('nim', $nim)
            ->where('status', 'selesai')
            ->first();

        if ($skPembimbing) {
            return response()->json([
                'found' => true,
                'pembimbing_1_id' => $skPembimbing->pembimbing_1_id,
                'pembimbing_1_nama' => $skPembimbing->pembimbing1->nama_dosen ?? '-',
                'pembimbing_2_id' => $skPembimbing->pembimbing_2_id,
                'pembimbing_2_nama' => $skPembimbing->pembimbing2->nama_dosen ?? '-',
            ]);
        }

        return response()->json(['found' => false]);
    }
}
