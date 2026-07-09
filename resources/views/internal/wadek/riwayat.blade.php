@extends('layouts.internal')

@section('title', 'Riwayat Validasi Wadek 1')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Riwayat Validasi SK</h2>
            <p class="text-muted mb-0">Daftar pengajuan SK Pembimbing dan SK Ujian yang telah selesai diproses.</p>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ url()->current() }}" method="GET" class="d-flex w-25">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 border-end-0"
                    placeholder="Cari Nama / NIM..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary border-start-0">Cari</button>
            </div>
        </form>
    </div>

    <!-- Navigasi Tabs -->
    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill shadow-sm border" id="wadekRiwayatTabs" role="tablist"
        style="width: fit-content;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill d-flex align-items-center" id="riwayat-pembimbing-tab"
                data-bs-toggle="pill" data-bs-target="#riwayat-pembimbing" type="button" role="tab">
                <i class="bi bi-person-check-fill me-2"></i> SK Pembimbing
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill d-flex align-items-center" id="riwayat-penguji-tab"
                data-bs-toggle="pill" data-bs-target="#riwayat-penguji" type="button" role="tab">
                <i class="bi bi-file-earmark-check me-2"></i> SK Ujian
            </button>
        </li>
    </ul>

    <!-- Konten Tabs -->
    <div class="tab-content" id="wadekRiwayatTabsContent">

        <!-- ========================================== -->
        <!-- TAB RIWAYAT SK PEMBIMBING                  -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="riwayat-pembimbing" role="tabpanel">
            <div class="table-container border-top-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white shadow-sm rounded-4 overflow-hidden">
                        <thead class="bg-light">
                            <tr>
                                <th>Mahasiswa (Pembimbing)</th>
                                <th>Program Studi</th>
                                <th>Status</th>
                                <th class="text-end">Tgl Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatSkPembimbing as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar bg-success-subtle text-success fw-bold">
                                                {{ substr($item->nama_mahasiswa, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $item->nama_mahasiswa }}</div>
                                                <small class="text-muted">NIM. {{ $item->nim }}</small>

                                                @if ($item->pembimbing1)
                                                    <div class="mt-1 text-success"
                                                        style="font-size: 12px; font-weight: 500;">
                                                        <i class="bi bi-person-badge-fill"></i> P1:
                                                        {{ $item->pembimbing1->nama_dosen ?? ($item->pembimbing1->nama ?? $item->pembimbing1->name) }}
                                                    </div>
                                                @endif
                                                @if ($item->pembimbing2)
                                                    <div class="text-primary" style="font-size: 12px; font-weight: 500;">
                                                        <i class="bi bi-person-badge"></i> P2:
                                                        {{ $item->pembimbing2->nama_dosen ?? ($item->pembimbing2->nama ?? $item->pembimbing2->name) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">
                                            {{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->status == 'siap_dicetak')
                                            <span
                                                class="badge bg-info-subtle text-info fw-semibold px-3 py-2 rounded-pill">Siap
                                                Dicetak Admin</span>
                                        @elseif($item->status == 'selesai')
                                            <span
                                                class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-muted small">
                                        {{ $item->updated_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="bi bi-clock-history d-block fs-2 mb-2 text-black-50"></i> Belum ada
                                        riwayat validasi SK Pembimbing.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center mt-4 mb-4">
                {{ $riwayatSkPembimbing->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB RIWAYAT SK UJIAN                       -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="riwayat-penguji" role="tabpanel">
            <div class="table-container border-top-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white shadow-sm rounded-4 overflow-hidden">
                        <thead class="bg-light">
                            <tr>
                                <th>Mahasiswa (Penguji)</th>
                                <th>Program Studi</th>
                                <th>Status</th>
                                <th class="text-end">Tgl Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatSkUjian as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar bg-primary-subtle text-primary fw-bold">
                                                {{ substr($item->nama_mahasiswa, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $item->nama_mahasiswa }}</div>
                                                <small class="text-muted">NIM. {{ $item->nim }}</small> | <span
                                                    class="text-uppercase fw-semibold">{{ $item->jenis_ujian }}</span></small>

                                                <div class="mt-1 d-flex flex-column gap-1"
                                                    style="font-size: 12px; font-weight: 500;">
                                                    @if ($item->ketuaPenguji)
                                                        <span class="text-danger"><i class="bi bi-person-badge-fill"></i>
                                                            Ketua:
                                                            {{ $item->ketuaPenguji->nama_dosen ?? $item->ketuaPenguji->nama }}</span>
                                                    @endif
                                                    @if ($item->sekretaris)
                                                        <span class="text-warning text-darken"><i
                                                                class="bi bi-person-badge"></i> Sek:
                                                            {{ $item->sekretaris->nama_dosen ?? $item->sekretaris->nama }}</span>
                                                    @endif
                                                    @if ($item->anggota1)
                                                        <span class="text-primary"><i class="bi bi-person"></i> A1:
                                                            {{ $item->anggota1->nama_dosen ?? $item->anggota1->nama }}</span>
                                                    @endif
                                                    @if ($item->anggota2)
                                                        <span class="text-info text-darken"><i class="bi bi-person"></i> A2:
                                                            {{ $item->anggota2->nama_dosen ?? $item->anggota2->nama }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">
                                            {{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->status == 'siap_dicetak')
                                            <span
                                                class="badge bg-info-subtle text-info fw-semibold px-3 py-2 rounded-pill">Siap
                                                Dicetak Admin</span>
                                        @elseif($item->status == 'selesai')
                                            <span
                                                class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-muted small">
                                        {{ $item->updated_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="bi bi-clock-history d-block fs-2 mb-2 text-black-50"></i> Belum ada
                                        riwayat validasi SK Ujian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center mt-4 mb-4">
                {{ $riwayatSkUjian->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection
