@extends('layouts.internal')

@section('title', 'Dashboard Admin Prodi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Ruang Kerja Admin Prodi</h2>
            <p class="text-muted mb-0">Pantau antrean pengajuan mahasiswa dan tentukan formasi dosen pembimbing.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card-stat p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Tugas Saya (Antrean)</span>
                        <h3 class="fw-bold text-dark m-0">{{ $menungguPengecekan }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-warning-subtle text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-stat p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Sedang di Meja Wadek</span>
                        <h3 class="fw-bold text-dark m-0">{{ $butuhAccWadek }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-primary-subtle text-primary">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-stat p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Total SK Selesai</span>
                        <h3 class="fw-bold text-dark m-0">{{ $selesaiBulanIni }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-success-subtle text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('internal.dashboard') }}" data-pjax
        class="row g-3 p-4 bg-light border-bottom rounded-top">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="persetujuan_wadek" {{ request('status') == 'persetujuan_wadek' ? 'selected' : '' }}>Menunggu
                    Wadek</option>
                <option value="siap_dicetak" {{ request('status') == 'siap_dicetak' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('internal.dashboard') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <div class="table-container border-top-0">
        <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-list-task me-2 text-success"></i> Antrean Pengajuan SK
                Pembimbing</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanSk as $item)
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
                                            <div class="mt-1 text-success" style="font-size: 12px; font-weight: 500;">
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
                                    @if ($item->catatan_admin && $item->status == 'diajukan')
                                        <div class="alert alert-danger p-2 mt-2 mb-0 ms-2" style="font-size: 11px;">
                                            <i class="bi bi-exclamation-triangle-fill"></i> <strong>Revisi Wadek:</strong>
                                            {{ $item->catatan_admin }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $item->prodi }}</div>
                            </td>
                            <td>
                                @if ($item->status == 'diajukan')
                                    <span
                                        class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2 rounded-pill">Diajukan
                                        (Tugas Anda)
                                    </span>
                                @elseif($item->status == 'persetujuan_wadek')
                                    <span
                                        class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Persetujuan
                                        Wadek</span>
                                @elseif($item->status == 'siap_dicetak')
                                    <span
                                        class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">Siap
                                        Dicetak</span>
                                @else
                                    <span
                                        class="badge bg-secondary-subtle text-secondary fw-semibold px-3 py-2 rounded-pill">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if ($item->status == 'diajukan')
                                        <button type="button" class="btn btn-success btn-action shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#modalProdi{{ $item->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Plotting Dosen
                                        </button>
                                    @elseif($item->status == 'siap_dicetak')
                                        <button type="button" class="btn btn-info text-white btn-action shadow-sm">
                                            <i class="bi bi-printer-fill me-1"></i> Cetak SK
                                        </button>
                                    @else
                                        <button class="btn btn-light text-muted btn-action border" disabled><i
                                                class="bi bi-check me-1"></i> Selesai Diproses</button>
                                    @endif

                                    @if ($item->status == 'diajukan')
                                        <form action="{{ route('internal.pengajuan.destroy', $item->id) }}" method="POST"
                                            class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action shadow-sm"
                                                title="Hapus Pengajuan">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if ($item->status == 'diajukan')
                            <div class="modal fade" id="modalProdi{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg text-start">
                                    <div class="modal-content rounded-4 shadow">
                                        <form action="{{ route('validasi.sk-pembimbing.prodi', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark"><i
                                                        class="bi bi-person-plus-fill text-success me-2"></i>Tentukan
                                                    Formasi Pembimbing</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-4">
                                                <div
                                                    class="d-flex justify-content-between align-items-start p-3 bg-light border rounded-3 mb-4">
                                                    <div>
                                                        <p class="mb-1 text-dark"><strong>Mahasiswa:</strong>
                                                            {{ $item->nama_mahasiswa }} ({{ $item->nim }})</p>
                                                        <p class="mb-0 text-muted" style="font-size: 14px;">
                                                            <strong>Judul:</strong> "{{ $item->judul_skripsi }}"
                                                        </p>
                                                    </div>
                                                    <div class="ms-3 text-end">
                                                        @if ($item->path_file_syarat)
                                                            <a href="{{ asset('storage/' . $item->path_file_syarat) }}"
                                                                target="_blank"
                                                                class="btn btn-sm btn-danger shadow-sm text-nowrap">
                                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cek Berkas
                                                            </a>
                                                        @else
                                                            <span class="badge bg-secondary">Tidak ada berkas</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih
                                                        Pembimbing Utama (P1)</label>
                                                    <select name="pembimbing_1_id" class="form-select rounded-3 py-2"
                                                        required>
                                                        <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                                        @foreach ($listDosen as $dosen)
                                                            <option value="{{ $dosen->id }}">
                                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                                (Bim: {{ $dosen->total_bimbingan }} | Prop:
                                                                {{ $dosen->jml_proposal }} | Has: {{ $dosen->jml_hasil }}
                                                                | Skr: {{ $dosen->jml_skripsi }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih
                                                        Pembimbing Pendamping (P2)</label>
                                                    <select name="pembimbing_2_id" class="form-select rounded-3 py-2"
                                                        required>
                                                        <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                                        @foreach ($listDosen as $dosen)
                                                            <option value="{{ $dosen->id }}">
                                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                                (Bim: {{ $dosen->total_bimbingan }} | Prop:
                                                                {{ $dosen->jml_proposal }} | Has: {{ $dosen->jml_hasil }}
                                                                | Skr: {{ $dosen->jml_skripsi }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-3 fw-semibold px-4"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit"
                                                    class="btn btn-success rounded-3 fw-semibold px-4">Kirim ke Wadek
                                                    1</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x d-block fs-2 mb-2 text-black-50"></i> Belum ada antrean berkas
                                pengajuan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex flex-column align-items-center mt-5 mb-4">
                <nav aria-label="Page navigation">
                    {{ $pengajuanSk->links('pagination::bootstrap-5') }}
                </nav>
                @if ($pengajuanSk->total() > 0)
                    <div class="text-muted small mb-3 bg-white px-3 py-1 rounded-pill border shadow-sm mt-3">
                        Menampilkan
                        <span class="fw-bold text-dark">{{ $pengajuanSk->firstItem() }}</span> -
                        <span class="fw-bold text-dark">{{ $pengajuanSk->lastItem() }}</span> dari
                        <span class="fw-bold text-dark">{{ $pengajuanSk->total() }}</span> pengajuan
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
