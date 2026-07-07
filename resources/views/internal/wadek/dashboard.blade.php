@extends('layouts.internal')

@section('title', 'Ruang Kerja Wakil Dekan 1')

@section('sidebar_menu')
    <a class="nav-link-custom {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}" href="{{ route('internal.dashboard') }}">
        <i class="bi bi-shield-check"></i> Validasi Dokumen
    </a>
    <a class="nav-link-custom" href="#">
        <i class="bi bi-bar-chart-line"></i> Rekapitulasi & Laporan
    </a>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Validasi Dokumen Akademik</h2>
            <p class="text-muted mb-0">Tinjau dan sahkan usulan formasi dosen pembimbing.</p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6">
            <div class="card-stat p-4 border-start border-primary border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Butuh Persetujuan Saya</span>
                        <h3 class="fw-bold text-dark m-0">{{ $butuhAccWadek }}</h3>
                    </div>
                    <div class="icon-shape bg-primary-subtle text-primary"><i class="bi bi-file-earmark-check-fill"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card-stat p-4 border-start border-success border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Disahkan Bulan Ini</span>
                        <h3 class="fw-bold text-dark m-0">{{ $selesaiBulanIni }}</h3>
                    </div>
                    <div class="icon-shape bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR TAB -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}" href="{{ route('internal.dashboard') }}">
                <i class="bi bi-inbox-fill me-1"></i> Perlu Diproses
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('wadek.riwayat') ? 'active' : '' }}" href="{{ route('wadek.riwayat') }}">
                <i class="bi bi-clock-history me-1"></i> Riwayat ACC
            </a>
        </li>
    </ul>

    <!-- Tabel Data -->
    <div class="table-container">
        <div class="p-4 bg-white border-bottom"><h5 class="fw-bold m-0"><i class="bi bi-inboxes text-primary me-2"></i> Dokumen Menunggu Pengesahan</h5></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Mahasiswa & Usulan Judul</th><th>Prodi</th><th>Status</th><th class="text-end">Tindakan</th></tr></thead>
                <tbody>
                    @forelse($pengajuanSk as $item)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $item->nama_mahasiswa }} <span class="text-muted small">(NIM. {{ $item->nim }})</span></div>
                                <div class="text-muted small">"{{ $item->judul_skripsi }}"</div>
                            </td>
                            <td>{{ $item->prodi }}</td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill">Butuh ACC Anda</span></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalWadek{{ $item->id }}">
                                    <i class="bi bi-shield-check"></i> Tinjau
                                </button>
                            </td>
                        </tr>
                        <!-- Modal (Letakkan di sini sesuai contoh sebelumnya) -->
                    @empty
                        <tr><td colspan="4" class="text-center py-5">Tidak ada dokumen menunggu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection