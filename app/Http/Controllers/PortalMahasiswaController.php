<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSkPembimbing;
use App\Models\PengajuanSkUjian;
use App\Models\ProgramStudi;

class PortalMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil 50 antrean terbaru yang sedang diproses (belum selesai)
        $skPembimbingAktif = PengajuanSkPembimbing::where('status', '!=', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->limit(50)
            ->get();

        $skUjianAktif = PengajuanSkUjian::where('status', '!=', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->limit(50)
            ->get();

        return view('portal.index', compact('skPembimbingAktif', 'skUjianAktif'));
    }
}
