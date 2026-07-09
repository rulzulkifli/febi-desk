<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PengajuanSkPembimbing;
use App\Models\PengajuanSkUjian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternalDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil Data Dosen untuk Dropdown
        $listDosen = \App\Models\Dosen::all();

        // 2. LOGIKA UNTUK ADMIN PRODI
        // 2. LOGIKA UNTUK ADMIN PRODI
        // 2. LOGIKA UNTUK ADMIN PRODI
        if ($user->peran == 'admin_prodi') {

            $queryPembimbing = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2', 'programStudi'])->latest();

            // --- PECAH QUERY BERDASARKAN JENIS UJIAN ---
            $queryUjianProposal = \App\Models\PengajuanSkUjian::with(['ketuaPenguji', 'sekretaris', 'anggota1', 'anggota2', 'programStudi'])
                ->where('jenis_ujian', 'proposal')->latest();
            $queryUjianHasil    = \App\Models\PengajuanSkUjian::with(['ketuaPenguji', 'sekretaris', 'anggota1', 'anggota2', 'programStudi'])
                ->where('jenis_ujian', 'hasil')->latest();
            $queryUjianSkripsi  = \App\Models\PengajuanSkUjian::with(['ketuaPenguji', 'sekretaris', 'anggota1', 'anggota2', 'programStudi'])
                ->where('jenis_ujian', 'skripsi')->latest();

            // Filter Status & Tanggal (Hanya untuk Admin)
            if ($request->filled('status')) {
                $queryPembimbing->where('status', $request->status);
                $queryUjianProposal->where('status', $request->status);
                $queryUjianHasil->where('status', $request->status);
                $queryUjianSkripsi->where('status', $request->status);
            }
            if ($request->filled('tanggal')) {
                $queryPembimbing->whereDate('created_at', $request->tanggal);
                $queryUjianProposal->whereDate('created_at', $request->tanggal);
                $queryUjianHasil->whereDate('created_at', $request->tanggal);
                $queryUjianSkripsi->whereDate('created_at', $request->tanggal);
            }

            // --- HITUNG BADGE: HANYA STATUS 'diajukan' (YANG BUTUH TINDAKAN ADMIN PRODI) ---
            $badgePembimbingCount = (clone $queryPembimbing)->where('status', 'diajukan')->count();
            $badgeProposalCount   = (clone $queryUjianProposal)->where('status', 'diajukan')->count();
            $badgeHasilCount      = (clone $queryUjianHasil)->where('status', 'diajukan')->count();
            $badgeSkripsiCount    = (clone $queryUjianSkripsi)->where('status', 'diajukan')->count();

            // Total Ujian aktif untuk badge utama
            $totalUjian = $badgeProposalCount + $badgeHasilCount + $badgeSkripsiCount;

            // Proses Pagination Data Tabel Utama
            $pengajuanSkPembimbing = $queryPembimbing->paginate(10, ['*'], 'page_pembimbing')->withQueryString();
            $ujianProposal = $queryUjianProposal->paginate(10, ['*'], 'page_proposal')->withQueryString();
            $ujianHasil    = $queryUjianHasil->paginate(10, ['*'], 'page_hasil')->withQueryString();
            $ujianSkripsi  = $queryUjianSkripsi->paginate(10, ['*'], 'page_skripsi')->withQueryString();

            // Statistik Khusus Dashboard Admin
            $menungguPengecekan = PengajuanSkPembimbing::where('status', 'diajukan')->count()
                + \App\Models\PengajuanSkUjian::where('status', 'diajukan')->count();

            $butuhAccWadek = PengajuanSkPembimbing::where('status', 'persetujuan_wadek')->count()
                + \App\Models\PengajuanSkUjian::where('status', 'persetujuan_wadek')->count();

            $selesaiPembimbing = PengajuanSkPembimbing::whereIn('status', ['siap_dicetak', 'selesai'])
                ->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', date('Y'))->count();

            $selesaiUjian = \App\Models\PengajuanSkUjian::whereIn('status', ['siap_dicetak', 'selesai'])
                ->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', date('Y'))->count();

            $selesaiBulanIni = $selesaiPembimbing + $selesaiUjian;

            return view('internal.admin.dashboard', compact(
                'pengajuanSkPembimbing',
                'ujianProposal',
                'ujianHasil',
                'ujianSkripsi',
                'badgePembimbingCount',
                'badgeProposalCount',
                'badgeHasilCount',
                'badgeSkripsiCount',
                'totalUjian',
                'listDosen',
                'menungguPengecekan',
                'butuhAccWadek',
                'selesaiBulanIni'
            ));

            // 3. LOGIKA UNTUK WADEK 1
        } elseif ($user->peran == 'wadek_1') {

            $pengajuanSkPembimbing = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2', 'programStudi'])
                ->where('status', 'persetujuan_wadek')
                ->latest()
                ->paginate(10, ['*'], 'page_pembimbing');

            // --- PECAH QUERY BERDASARKAN JENIS UJIAN UNTUK WADEK ---
            $baseUjianQuery = \App\Models\PengajuanSkUjian::with(['ketuaPenguji', 'sekretaris', 'anggota1', 'anggota2', 'programStudi'])
                ->where('status', 'persetujuan_wadek')
                ->latest();

            $ujianProposalWadek = (clone $baseUjianQuery)->where('jenis_ujian', 'proposal')->paginate(10, ['*'], 'page_proposal');
            $ujianHasilWadek    = (clone $baseUjianQuery)->where('jenis_ujian', 'hasil')->paginate(10, ['*'], 'page_hasil');
            $ujianSkripsiWadek  = (clone $baseUjianQuery)->where('jenis_ujian', 'skripsi')->paginate(10, ['*'], 'page_skripsi');

            // Hitung Badge
            $badgeProposalWadek = $ujianProposalWadek->total();
            $badgeHasilWadek    = $ujianHasilWadek->total();
            $badgeSkripsiWadek  = $ujianSkripsiWadek->total();
            $totalUjianWadek    = $badgeProposalWadek + $badgeHasilWadek + $badgeSkripsiWadek;

            // --- TAMBAHAN: HITUNG MONITORING WADEK ---
            $butuhAccWadek = PengajuanSkPembimbing::where('status', 'persetujuan_wadek')->count()
                + \App\Models\PengajuanSkUjian::where('status', 'persetujuan_wadek')->count();

            $selesaiPembimbing = PengajuanSkPembimbing::whereIn('status', ['siap_dicetak', 'selesai'])
                ->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', date('Y'))->count();

            $selesaiUjian = \App\Models\PengajuanSkUjian::whereIn('status', ['siap_dicetak', 'selesai'])
                ->whereMonth('updated_at', date('m'))
                ->whereYear('updated_at', date('Y'))->count();

            $accBulanIni = $selesaiPembimbing + $selesaiUjian;
            // ------------------------------------------

            return view('internal.wadek.dashboard', compact(
                'pengajuanSkPembimbing',
                'listDosen',
                'ujianProposalWadek',
                'ujianHasilWadek',
                'ujianSkripsiWadek',
                'badgeProposalWadek',
                'badgeHasilWadek',
                'badgeSkripsiWadek',
                'totalUjianWadek',
                'butuhAccWadek', // Tambahkan ini
                'accBulanIni'    // Tambahkan ini
            ));

            // 4. JIKA PERAN TIDAK DIKENAL
        } else {
            return redirect()->route('febi.login')->with('error', 'Akses tidak diizinkan.');
        }
    }

    // Proses Plotting Dosen oleh Admin Prodi dan Teruskan ke Wadek
    public function prosesProdi(Request $request, $id)
    {
        // 1. Validasi input form (sesuaikan field dengan form Anda)
        $request->validate([
            'pembimbing_1_id' => 'required|exists:dosen,id',
            'pembimbing_2_id' => 'nullable|exists:dosen,id|different:pembimbing_1_id',
        ]);

        // 2. Cari data pengajuan
        $pengajuan = PengajuanSkPembimbing::findOrFail($id);

        // 3. Update dosen pembimbing dan ubah status agar masuk ke dashboard Wadek 1
        $pengajuan->update([
            'pembimbing_1_id' => $request->pembimbing_1_id,
            'pembimbing_2_id' => $request->pembimbing_2_id,
            'status'          => 'persetujuan_wadek'
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Plotting dosen pembimbing berhasil disimpan dan diteruskan ke Wadek 1 untuk di-ACC.');
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

        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus permanen.');
    }

    public function hapusPengajuanUjian(Request $request, $id)
    {
        $pengajuan = PengajuanSkUjian::findOrFail($id);

        // Hapus data dari database
        $pengajuan->delete();

        return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus permanen.');
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
        $search = $request->input('search');

        // Hapus 'user' dari with()
        $queryPembimbing = PengajuanSkPembimbing::with(['pembimbing1', 'pembimbing2'])
            ->whereIn('status', ['siap_dicetak', 'selesai']);

        // Hapus 'user' dari with()
        $queryUjian = PengajuanSkUjian::with(['ketuaPenguji', 'sekretaris', 'anggota1', 'anggota2'])
            ->whereIn('status', ['siap_dicetak', 'selesai']);

        if ($search) {
            $queryPembimbing->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
            });
            $queryUjian->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $riwayatSkPembimbing = $queryPembimbing->latest()->paginate(10, ['*'], 'page_pembimbing');
        $riwayatSkUjian = $queryUjian->latest()->paginate(10, ['*'], 'page_ujian');

        return view('internal.wadek.riwayat', compact('riwayatSkPembimbing', 'riwayatSkUjian'));
    }

    public function monitoringDosen(Request $request)
    {
        // Default range: 1 bulan terakhir jika tanggal tidak diisi
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Siapkan waktu lengkap untuk query data antara 00:00:00 sampai 23:59:59
        $startDateTime = $startDate . ' 00:00:00';
        $endDateTime = $endDate . ' 23:59:59';

        // 1. Ambil agregasi data Pembimbing 1 (Hanya yang sudah di-ACC Wadek: siap_dicetak, selesai)
        $pembimbing1Counts = DB::table('pengajuan_sk_pembimbing')
            ->select('pembimbing_1_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Hilangkan 'persetujuan_wadek'
            ->groupBy('pembimbing_1_id')
            ->pluck('total', 'pembimbing_1_id');

        // 2. Ambil agregasi data Pembimbing 2 (Hanya yang sudah di-ACC Wadek: siap_dicetak, selesai)
        $pembimbing2Counts = DB::table('pengajuan_sk_pembimbing')
            ->select('pembimbing_2_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Hilangkan 'persetujuan_wadek'
            ->groupBy('pembimbing_2_id')
            ->pluck('total', 'pembimbing_2_id');

        // 3. Ambil agregasi data Penguji (Tambahkan filter status 'siap_dicetak', 'selesai')
        $ketuaCounts = DB::table('pengajuan_sk_ujian')
            ->select('ketua_penguji_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Ditambahkan filter status
            ->groupBy('ketua_penguji_id')->pluck('total', 'ketua_penguji_id');

        $sekretarisCounts = DB::table('pengajuan_sk_ujian')
            ->select('sekretaris_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Ditambahkan filter status
            ->groupBy('sekretaris_id')->pluck('total', 'sekretaris_id');

        $anggota1Counts = DB::table('pengajuan_sk_ujian')
            ->select('anggota_1_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Ditambahkan filter status
            ->groupBy('anggota_1_id')->pluck('total', 'anggota_1_id');

        $anggota2Counts = DB::table('pengajuan_sk_ujian')
            ->select('anggota_2_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->whereIn('status', ['siap_dicetak', 'selesai']) // Ditambahkan filter status
            ->groupBy('anggota_2_id')->pluck('total', 'anggota_2_id');

        // Ambil semua data dosen untuk dipetakan statistiknya
        $allDosen = Dosen::all()->map(function ($dosen) use ($pembimbing1Counts, $pembimbing2Counts, $ketuaCounts, $sekretarisCounts, $anggota1Counts, $anggota2Counts) {
            $dosen->p1_count = $pembimbing1Counts->get($dosen->id, 0);
            $dosen->p2_count = $pembimbing2Counts->get($dosen->id, 0);

            // Total Menguji gabungan dari keempat posisi
            $dosen->penguji_count = $ketuaCounts->get($dosen->id, 0)
                + $sekretarisCounts->get($dosen->id, 0)
                + $anggota1Counts->get($dosen->id, 0)
                + $anggota2Counts->get($dosen->id, 0);

            // Total Kontribusi Keseluruhan
            $dosen->total_kontribusi = $dosen->p1_count + $dosen->p2_count + $dosen->penguji_count;

            return $dosen;
            // ... (biarkan fungsi map collection dosen tetap seperti sebelumnya)
        })->sortByDesc('total_kontribusi'); // Urutkan dari dosen dengan kontribusi tertinggi

        // ---- PAGINASI MANUAL UNTUK COLLECTION ----
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $allDosen->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $dosenPaginated = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($allDosen), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('internal.dosen.monitoring', compact('dosenPaginated', 'startDate', 'endDate'));
    }

    // Proses Plotting Tim Penguji oleh Admin Prodi
    // Proses Plotting Tim Penguji oleh Admin Prodi
    public function prosesUjianProdi(Request $request, $id)
    {
        $pengajuan = \App\Models\PengajuanSkUjian::findOrFail($id);

        // 1. Tambahkan validasi untuk tanggal dan waktu
        $rules = [
            'tanggal_ujian'    => 'required|date',
            'waktu_ujian'      => 'required|string',
            'ketua_penguji_id' => 'required|exists:dosen,id',
            'sekretaris_id'    => 'required|exists:dosen,id',
            'anggota_1_id'     => 'required|exists:dosen,id',
        ];

        if ($pengajuan->jenis_ujian !== 'proposal') {
            $rules['anggota_2_id'] = 'required|exists:dosen,id|different:anggota_1_id';
        }

        $request->validate($rules);

        // 2. Tambahkan field ke dalam array untuk disimpan ke database
        $updateData = [
            'tanggal_ujian'    => $request->tanggal_ujian,
            'waktu_ujian'      => $request->waktu_ujian,
            'ketua_penguji_id' => $request->ketua_penguji_id,
            'sekretaris_id'    => $request->sekretaris_id,
            'anggota_1_id'     => $request->anggota_1_id,
            'status'           => 'persetujuan_wadek'
        ];

        if ($pengajuan->jenis_ujian !== 'proposal') {
            $updateData['anggota_2_id'] = $request->anggota_2_id;
        } else {
            $updateData['anggota_2_id'] = null;
        }

        $pengajuan->update($updateData);

        return redirect()->back()->with('success', 'Jadwal dan Formasi tim penguji berhasil disimpan serta diteruskan ke Wadek 1.');
    }

    // Proses Validasi Tim Penguji oleh Wadek 1 (Bisa edit formasi, tanggal & waktu)
    public function prosesUjianWadek(Request $request, $id)
    {
        $pengajuan = \App\Models\PengajuanSkUjian::findOrFail($id);

        $rules = [
            'tanggal_ujian'    => 'required|date',
            'waktu_ujian'      => 'required',
            'ketua_penguji_id' => 'required|exists:dosen,id',
            'sekretaris_id'    => 'required|exists:dosen,id',
            'anggota_1_id'     => 'required|exists:dosen,id',
        ];

        if ($pengajuan->jenis_ujian !== 'proposal') {
            $rules['anggota_2_id'] = 'required|exists:dosen,id|different:anggota_1_id';
        }

        $request->validate($rules);

        $updateData = [
            'tanggal_ujian'    => $request->tanggal_ujian,
            'waktu_ujian'      => $request->waktu_ujian,
            'ketua_penguji_id' => $request->ketua_penguji_id,
            'sekretaris_id'    => $request->sekretaris_id,
            'anggota_1_id'     => $request->anggota_1_id,
            'status'           => 'siap_dicetak' // Tahap akhir ACC
        ];

        if ($pengajuan->jenis_ujian !== 'proposal') {
            $updateData['anggota_2_id'] = $request->anggota_2_id;
        }

        $pengajuan->update($updateData);

        return redirect()->back()->with('success', 'SK Ujian beserta jadwalnya berhasil divalidasi dan di-ACC oleh Wadek 1.');
    }

    public function tolakUjianWadek(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ]);

        $pengajuan = \App\Models\PengajuanSkUjian::findOrFail($id);

        $pengajuan->update([
            'status' => 'diajukan',
            'catatan_admin' => $request->catatan_penolakan
        ]);

        return redirect()->back()->with('success', 'Dokumen Pengajuan Ujian telah dikembalikan ke Admin Prodi dengan catatan revisi.');
    }
}
