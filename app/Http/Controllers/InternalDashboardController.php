<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PengajuanSkPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternalDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi Query dasar (mengambil data dengan relasi Dosen)
        $query = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2'])->latest();

        // 2. Terapkan Filter yang berlaku umum
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // 3. LOGIKA PEMISAHAN PERAN (ROLE)
        $user = Auth::user();

        if ($user->peran == 'admin_prodi') {
            // Filter status khusus untuk Admin
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            $pengajuanSk = $query->paginate(10)->withQueryString();
        } elseif ($user->peran == 'wadek_1') {
            // Wadek: Hanya tampilkan yang perlu di-ACC (persetujuan_wadek)
            $pengajuanSk = $query->where('status', 'persetujuan_wadek')
                ->paginate(10)
                ->withQueryString();
        } else {
            return redirect()->route('febi.login')->with('error', 'Akses tidak diizinkan.');
        }

        // 4. Data Dosen untuk Dropdown (Beban Tugas Real-time)
        $listDosen = Dosen::all()->map(function ($dosen) {
            $dosen->total_bimbingan = PengajuanSkPembimbing::whereIn('status', ['siap_dicetak', 'selesai'])
                ->where(function ($q) use ($dosen) {
                    $q->where('pembimbing_1_id', $dosen->id)->orWhere('pembimbing_2_id', $dosen->id);
                })->count();

            // Statistik Penguji SAH
            $dosen->jml_proposal = DB::table('pengajuan_sk_ujian')->where('jenis_ujian', 'proposal')->whereIn('status', ['siap_dicetak', 'selesai'])
                ->where(function ($q) use ($dosen) {
                    $q->where('pembimbing_1_id', $dosen->id)->orWhere('pembimbing_2_id', $dosen->id);
                })->count();
            $dosen->jml_hasil = DB::table('pengajuan_sk_ujian')->where('jenis_ujian', 'hasil')->whereIn('status', ['siap_dicetak', 'selesai'])
                ->where(function ($q) use ($dosen) {
                    $q->where('pembimbing_1_id', $dosen->id)->orWhere('pembimbing_2_id', $dosen->id);
                })->count();
            $dosen->jml_skripsi = DB::table('pengajuan_sk_ujian')->where('jenis_ujian', 'skripsi')->whereIn('status', ['siap_dicetak', 'selesai'])
                ->where(function ($q) use ($dosen) {
                    $q->where('pembimbing_1_id', $dosen->id)->orWhere('pembimbing_2_id', $dosen->id);
                })->count();

            return $dosen;
        });

        // 5. Statistik Dashboard
        $menungguPengecekan = PengajuanSkPembimbing::where('status', 'diajukan')->count();
        $butuhAccWadek = PengajuanSkPembimbing::where('status', 'persetujuan_wadek')->count();
        $selesaiBulanIni = PengajuanSkPembimbing::whereIn('status', ['siap_dicetak', 'selesai'])
            ->whereMonth('updated_at', date('m'))
            ->whereYear('updated_at', date('Y'))->count();

        // 6. Return ke View yang sesuai
        if ($user->peran == 'admin_prodi') {
            return view('internal.admin.dashboard', compact('pengajuanSk', 'listDosen', 'menungguPengecekan', 'butuhAccWadek', 'selesaiBulanIni'));
        } else {
            return view('internal.wadek.dashboard', compact('pengajuanSk', 'listDosen', 'butuhAccWadek', 'selesaiBulanIni'));
        }
    }

    // Proses Validasi & Sinkronisasi Akhir oleh Wadek 1 (Dapat mengedit pembimbing)
    public function prosesWadek(Request $request, $id)
    {
        $request->validate([
            'pembimbing_1_id' => 'required|exists:dosen,id',
            'pembimbing_2_id' => 'nullable|exists:dosen,id|different:pembimbing_1_id',
        ]);

        $pengajuan = PengajuanSkPembimbing::findOrFail($id);
        $pengajuan->update([
            'pembimbing_1_id' => $request->pembimbing_1_id,
            'pembimbing_2_id' => $request->pembimbing_2_id,
            'status'          => 'siap_dicetak' // Tahap akhir validasi selesai
        ]);

        return redirect()->back()->with('success', 'SK Pembimbing berhasil divalidasi dan di-ACC oleh Wadek 1.');
    }

    // Fitur Hapus Data Pengajuan & File PDF Fisiknya
    public function hapusPengajuan($id)
    {
        $pengajuan = PengajuanSkPembimbing::findOrFail($id);

        // Hapus file fisik PDF di folder public/storage agar hemat memori server
        if ($pengajuan->path_file_syarat) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengajuan->path_file_syarat);
        }

        // Hapus data dari database
        $pengajuan->delete();

        return redirect()->back()->with('success', 'Data pengajuan beserta berkas PDF-nya berhasil dihapus permanen.');
    }

    public function tolakWadek(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ]);

        $pengajuan = PengajuanSkPembimbing::findOrFail($id);

        // Mengembalikan status ke 'diajukan' agar kembali muncul di dashboard Admin
        // Kita simpan catatan penolakan ke database (pastikan kolom 'catatan_admin' atau 'catatan_wadek' ada)
        $pengajuan->update([
            'status' => 'diajukan',
            'catatan_admin' => $request->catatan_penolakan
        ]);

        return redirect()->back()->with('success', 'Dokumen telah dikembalikan ke Admin Prodi dengan catatan revisi.');
    }

    public function riwayatWadek(Request $request)
    {
        // Mengambil data yang sudah disahkan
        $pengajuanSk = \App\Models\PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2'])
            ->whereIn('status', ['siap_dicetak', 'selesai'])
            ->latest()
            ->paginate(10);

        return view('internal.wadek.riwayat', compact('pengajuanSk'));
    }
}
