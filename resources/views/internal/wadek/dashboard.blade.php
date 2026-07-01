@extends('layouts.internal')

@section('title', 'Ruang Kerja Wakil Dekan 1')

@section('sidebar_menu')
    <a class="nav-link-custom {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}"
        href="{{ route('internal.dashboard') }}">
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
            <p class="text-muted mb-0">Tinjau dan sahkan usulan formasi dosen pembimbing dari Program Studi.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6">
            <div class="card-stat p-4 border-start border-primary border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Butuh Persetujuan Saya</span>
                        <h3 class="fw-bold text-dark m-0">{{ $butuhAccWadek }} <span class="text-muted font-normal"
                                style="font-size: 14px;">dokumen</span></h3>
                    </div>
                    <div class="icon-shape bg-primary-subtle text-primary">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card-stat p-4 border-start border-success border-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Disahkan Bulan Ini</span>
                        <h3 class="fw-bold text-dark m-0">{{ $selesaiBulanIni }} <span class="text-muted font-normal"
                                style="font-size: 14px;">dokumen</span></h3>
                    </div>
                    <div class="icon-shape bg-success-subtle text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-inboxes text-primary me-2"></i> Dokumen Menunggu Pengesahan
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa & Usulan Judul</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanSk as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark mb-0">{{ $item->nama_mahasiswa }} <span
                                        class="text-muted font-normal small">(NIM. {{ $item->nim }})</span></div>
                                <div class="text-muted mt-1"
                                    style="font-size: 12px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    "{{ $item->judul_skripsi }}"
                                </div>

                                @if ($item->pembimbing1)
                                    <div class="mt-2 text-success" style="font-size: 12px; font-weight: 500;">
                                        <i class="bi bi-person-badge-fill"></i> Usulan P1:
                                        {{ $item->pembimbing1->nama_dosen ?? ($item->pembimbing1->nama ?? $item->pembimbing1->name) }}
                                    </div>
                                @endif
                                @if ($item->pembimbing2)
                                    <div class="text-primary" style="font-size: 12px; font-weight: 500;">
                                        <i class="bi bi-person-badge"></i> Usulan P1 :
                                        {{ $item->pembimbing2->nama_dosen ?? ($item->pembimbing2->nama ?? $item->pembimbing2->name) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $item->prodi }}</div>
                            </td>
                            <td>
                                @if ($item->status == 'persetujuan_wadek')
                                    <span
                                        class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Butuh
                                        ACC Anda</span>
                                @elseif($item->status == 'siap_dicetak' || $item->status == 'selesai')
                                    <span
                                        class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">Telah
                                        Disahkan</span>
                                @else
                                    <span
                                        class="badge bg-secondary-subtle text-secondary fw-semibold px-3 py-2 rounded-pill">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($item->status == 'persetujuan_wadek')
                                    <button type="button" class="btn btn-primary btn-action shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalWadek{{ $item->id }}">
                                        <i class="bi bi-shield-check me-1"></i> Tinjau & Sahkan
                                    </button>
                                @else
                                    <button class="btn btn-light text-muted btn-action border" disabled><i
                                            class="bi bi-check-all me-1"></i> Selesai Diproses</button>
                                @endif
                            </td>
                        </tr>

                        @if ($item->status == 'persetujuan_wadek')
                            <div class="modal fade" id="modalWadek{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg text-start">
                                    <div class="modal-content rounded-4 shadow">
                                        <form action="{{ route('validasi.sk-pembimbing.wadek', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold text-dark"><i
                                                        class="bi bi-shield-shaded text-primary me-2"></i>Validasi & Koreksi
                                                    Pilihan Dosen</h5>
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
                                                                class="btn btn-sm btn-outline-danger shadow-sm text-nowrap">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas PDF
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="alert alert-light border text-muted py-2 mb-3 rounded-3"
                                                    style="font-size: 13px;">
                                                    <i class="bi bi-info-circle-fill text-primary me-1"></i> Anda dapat
                                                    mengubah pembimbing pilihan prodi di bawah ini jika diperlukan.
                                                </div>

                                                <div class="mb-3">
                                                    <label
                                                        class="form-label fw-bold small text-muted text-uppercase">Pengesahan
                                                        Pembimbing 1</label>
                                                    <select name="pembimbing_1_id" class="form-select rounded-3 py-2"
                                                        required>
                                                        @foreach ($listDosen as $dosen)
                                                            <option value="{{ $dosen->id }}"
                                                                {{ $item->pembimbing_1_id == $dosen->id ? 'selected' : '' }}>
                                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                                (Bim: {{ $dosen->total_bimbingan }} | Prop:
                                                                {{ $dosen->jml_proposal }} | Has: {{ $dosen->jml_hasil }}
                                                                | Skr: {{ $dosen->jml_skripsi }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-0">
                                                    <label
                                                        class="form-label fw-bold small text-muted text-uppercase">Pengesahan
                                                        Pembimbing 2</label>
                                                    <select name="pembimbing_2_id" class="form-select rounded-3 py-2">
                                                        <option value="">-- Tanpa Pembimbing Pendamping --</option>
                                                        @foreach ($listDosen as $dosen)
                                                            <option value="{{ $dosen->id }}"
                                                                {{ $item->pembimbing_2_id == $dosen->id ? 'selected' : '' }}>
                                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                                (Bim: {{ $dosen->total_bimbingan }} | Prop:
                                                                {{ $dosen->jml_proposal }} | Has: {{ $dosen->jml_hasil }}
                                                                | Skr: {{ $dosen->jml_skripsi }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Di dalam Modal Tinjau & Sahkan Wadek, cari tombol "Setujui" lalu tambahkan tombol ini di sebelahnya -->
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-danger rounded-3 fw-semibold px-4"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseRevisi">
                                                    <i class="bi bi-x-circle me-1"></i> Tolak / Revisi
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-primary rounded-3 fw-semibold px-4"><i
                                                        class="bi bi-check2-circle me-1"></i> Setujui & Sahkan SK</button>
                                            </div>
                                        </form>
                                        <!-- Area Input Catatan (Hidden by default) -->
                                        <div class="collapse mt-3" id="collapseRevisi">
                                            <form action="{{ route('validasi.sk-pembimbing.tolak', $item->id) }}"
                                                method="POST" class="p-4 bg-danger-subtle rounded-3 border">
                                                @csrf
                                                @method('PATCH')

                                                <label class="fw-bold text-danger small mb-2 ms-1">
                                                    <i class="bi bi-pencil-square me-1"></i> Tuliskan Catatan Revisi :
                                                </label>

                                                <textarea name="catatan_penolakan" class="form-control mb-3" rows="3" required
                                                    placeholder="Contoh: Pembimbing 1 sudah melebihi kuota, harap ganti..."></textarea>

                                                <button type="submit" class="btn btn-danger w-100 fw-semibold">
                                                    Kirim Revisi ke Admin
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-inbox d-block fs-2 mb-2 text-black-50"></i> Tidak ada dokumen yang
                                membutuhkan pengesahan Anda saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
