@extends('layouts.internal')

@section('title', 'Dashboard Admin Prodi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Ruang Kerja Admin Prodi</h2>
            <p class="text-muted mb-0">Pantau antrean pengajuan mahasiswa dan tentukan formasi dosen pembimbing & penguji.
            </p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card-stat p-4 shadow-sm rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Tugas Saya (Antrean)</span>
                        <h3 class="fw-bold text-dark m-0">{{ $menungguPengecekan }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-stat p-4 shadow-sm rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Sedang di Meja Wadek</span>
                        <h3 class="fw-bold text-dark m-0">{{ $butuhAccWadek }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-primary-subtle text-primary"><i class="bi bi-file-earmark-check"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-stat p-4 shadow-sm rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Total SK Selesai</span>
                        <h3 class="fw-bold text-dark m-0">{{ $selesaiBulanIni }} <span class="text-muted font-normal"
                                style="font-size: 14px;">berkas</span></h3>
                    </div>
                    <div class="icon-shape bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i></div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('internal.dashboard') }}" class="row g-3 p-4 bg-white shadow-sm rounded-4 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan (Tugas Admin)
                </option>
                <option value="persetujuan_wadek" {{ request('status') == 'persetujuan_wadek' ? 'selected' : '' }}>Menunggu
                    Wadek</option>
                <option value="siap_dicetak" {{ request('status') == 'siap_dicetak' ? 'selected' : '' }}>Siap Dicetak
                </option>
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

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill shadow-sm border" id="adminTabs" role="tablist"
        style="width: fit-content;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill d-flex align-items-center" id="pembimbing-tab"
                data-bs-toggle="pill" data-bs-target="#pembimbing" type="button" role="tab">
                <i class="bi bi-person-lines-fill me-2"></i> Plotting Pembimbing
                @if (isset($badgePembimbingCount) && $badgePembimbingCount > 0)
                    <span class="badge bg-danger ms-2 rounded-pill shadow-sm">{{ $badgePembimbingCount }}</span>
                @endif
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill d-flex align-items-center" id="penguji-tab"
                data-bs-toggle="pill" data-bs-target="#penguji" type="button" role="tab">
                <i class="bi bi-file-earmark-person me-2"></i> Plotting Penguji
                @if (isset($totalUjian) && $totalUjian > 0)
                    <span class="badge bg-danger ms-2 rounded-pill shadow-sm">{{ $totalUjian }}</span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabsContent">

        <div class="tab-pane fade show active" id="pembimbing" role="tabpanel">
            <div class="table-container border-top-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Program Studi</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th class="text-end">Tindakan Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanSkPembimbing as $item)
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
                                                        <span class="badge bg-secondary-subtle text-secondary ms-1"
                                                            style="font-size: 9px;">{{ $item->pembimbing1->bebanDuaMinggu() }}</span>
                                                    </div>
                                                @endif
                                                @if ($item->pembimbing2)
                                                    <div class="text-primary" style="font-size: 12px; font-weight: 500;">
                                                        <i class="bi bi-person-badge"></i> P2:
                                                        {{ $item->pembimbing2->nama_dosen ?? ($item->pembimbing2->nama ?? $item->pembimbing2->name) }}
                                                        <span class="badge bg-secondary-subtle text-secondary ms-1"
                                                            style="font-size: 9px;">{{ $item->pembimbing2->bebanDuaMinggu() }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($item->catatan_admin && $item->status == 'diajukan')
                                                <div class="alert alert-danger p-2 mt-2 mb-0 ms-2"
                                                    style="font-size: 11px;">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> <strong>Revisi
                                                        Wadek:</strong> {{ $item->catatan_admin }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">
                                            {{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}"
                                            target="_blank" class="text-success text-decoration-none">
                                            <i class="bi bi-whatsapp"></i> {{ $item->no_hp }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->status == 'diajukan')
                                            <span
                                                class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2 rounded-pill">Tugas
                                                Anda</span>
                                        @elseif($item->status == 'persetujuan_wadek')
                                            <span
                                                class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Di
                                                Meja Wadek</span>
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
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalProdiPembimbing{{ $item->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Plotting Dosen
                                                </button>
                                                <form action="{{ route('internal.pengajuan.destroy', $item->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action shadow-sm"
                                                        title="Hapus Pengajuan"><i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            @elseif($item->status == 'siap_dicetak')
                                                <button type="button"
                                                    class="btn btn-info text-white btn-action shadow-sm"><i
                                                        class="bi bi-printer-fill me-1"></i> Cetak SK</button>
                                            @else
                                                <button class="btn btn-light text-muted btn-action border" disabled><i
                                                        class="bi bi-lock me-1"></i> Terkunci</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5"><i
                                            class="bi bi-folder-x d-block fs-2 mb-2 text-black-50"></i> Belum ada antrean
                                        SK Pembimbing.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center mt-4 mb-4">
                {{ $pengajuanSkPembimbing->appends(['status' => request('status'), 'tanggal' => request('tanggal')])->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="tab-pane fade" id="penguji" role="tabpanel">

            @php
                // Mapping data lengkap dengan nilai badge dinamis dari controller
                $ujianTabs = [
                    'proposal' => [
                        'title' => 'Ujian Proposal',
                        'data' => $ujianProposal ?? collect(),
                        'badge' => $badgeProposalCount ?? 0,
                    ],
                    'hasil' => [
                        'title' => 'Ujian Hasil',
                        'data' => $ujianHasil ?? collect(),
                        'badge' => $badgeHasilCount ?? 0,
                    ],
                    'skripsi' => [
                        'title' => 'Ujian Skripsi',
                        'data' => $ujianSkripsi ?? collect(),
                        'badge' => $badgeSkripsiCount ?? 0,
                    ],
                ];
            @endphp

            <ul class="nav nav-pills mb-3 border-bottom pb-3" id="pengujiSubTabs" role="tablist">
                @foreach ($ujianTabs as $key => $tab)
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link {{ $loop->first ? 'active' : '' }} fw-semibold rounded-pill px-4 py-2 me-2"
                            id="{{ $key }}-tab" data-bs-toggle="pill"
                            data-bs-target="#sub-{{ $key }}" type="button" role="tab">
                            {{ $tab['title'] }}
                            @if ($tab['badge'] > 0)
                                <span class="badge bg-danger ms-1 rounded-pill">{{ $tab['badge'] }}</span>
                            @endif
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="pengujiSubTabsContent">
                @foreach ($ujianTabs as $key => $tab)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="sub-{{ $key }}"
                        role="tabpanel">

                        <div class="table-container border-top-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Mahasiswa (Ujian)</th>
                                            <th>Program Studi</th>
                                            <th>No HP</th>
                                            <th>Status</th>
                                            <th class="text-end">Tindakan Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tab['data'] as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="user-avatar bg-primary-subtle text-primary fw-bold">
                                                            {{ substr($item->nama_mahasiswa, 0, 2) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark mb-0">
                                                                {{ $item->nama_mahasiswa }}</div>
                                                            <small class="text-muted">NIM. {{ $item->nim }} | <span
                                                                    class="text-uppercase fw-semibold">{{ $item->jenis_ujian }}</span></small>
                                                        </div>
                                                        @if ($item->catatan_admin && $item->status == 'diajukan')
                                                            <div class="alert alert-danger p-2 mt-2 mb-0 ms-2"
                                                                style="font-size: 11px;">
                                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                                <strong>Revisi
                                                                    Wadek:</strong> {{ $item->catatan_admin }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-medium text-dark">
                                                        {{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}"
                                                        target="_blank" class="text-success text-decoration-none">
                                                        <i class="bi bi-whatsapp"></i> {{ $item->no_hp }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'diajukan')
                                                        <span
                                                            class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2 rounded-pill">Tugas
                                                            Anda</span>
                                                    @elseif($item->status == 'persetujuan_wadek')
                                                        <span
                                                            class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Di
                                                            Meja Wadek</span>
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
                                                            <button type="button"
                                                                class="btn btn-primary btn-action shadow-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalProdiPenguji{{ $item->id }}">
                                                                <i class="bi bi-pencil-square me-1"></i> Plotting Penguji
                                                            </button>
                                                            <form
                                                                action="{{ route('internal.pengajuan-ujian.destroy', $item->id) }}"
                                                                method="POST" class="d-inline form-delete">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-action shadow-sm"
                                                                    title="Hapus Pengajuan"><i
                                                                        class="bi bi-trash-fill"></i></button>
                                                            </form>
                                                        @elseif($item->status == 'siap_dicetak')
                                                            <button type="button"
                                                                class="btn btn-info text-white btn-action shadow-sm"><i
                                                                    class="bi bi-printer-fill me-1"></i> Cetak SK</button>
                                                        @else
                                                            <button class="btn btn-light text-muted btn-action border"
                                                                disabled><i class="bi bi-lock me-1"></i> Terkunci</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-5">
                                                    <i class="bi bi-folder-x d-block fs-2 mb-2 text-black-50"></i> Belum
                                                    ada antrean untuk {{ $tab['title'] }}.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-center mt-4 mb-4">
                            {{ $tab['data']->appends(['status' => request('status'), 'tanggal' => request('tanggal')])->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

    </div>

    {{-- MODAL PLOTTING PEMBIMBING --}}
    @foreach ($pengajuanSkPembimbing as $item)
        @if ($item->status == 'diajukan')
            <div class="modal fade" id="modalProdiPembimbing{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg text-start">
                    <div class="modal-content rounded-4 shadow">
                        <form action="{{ route('validasi.sk-pembimbing.prodi', $item->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold text-dark"><i
                                        class="bi bi-person-plus-fill text-success me-2"></i>Tentukan Formasi Pembimbing
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body py-4">
                                <div
                                    class="d-flex justify-content-between align-items-start p-3 bg-light border rounded-3 mb-4">
                                    <div>
                                        <p class="mb-1 text-dark"><strong>Mahasiswa:</strong> {{ $item->nama_mahasiswa }}
                                            ({{ $item->nim }})</p>
                                        <p class="mb-0 text-muted" style="font-size: 14px;"><strong>Judul:</strong>
                                            "{{ $item->judul_skripsi }}"</p>
                                    </div>
                                    <div class="ms-3 text-end">
                                        @if ($item->path_file_syarat)
                                            <a href="{{ asset('storage/' . $item->path_file_syarat) }}" target="_blank"
                                                class="btn btn-sm btn-danger shadow-sm text-nowrap">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cek Berkas
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Pembimbing
                                        Utama (P1)</label>
                                    <select name="pembimbing_1_id" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->pembimbing_1_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Pembimbing
                                        Pendamping (P2)</label>
                                    <select name="pembimbing_2_id" class="form-select rounded-3 py-2">
                                        <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->pembimbing_2_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                                {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-3 fw-semibold px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-3 fw-semibold px-4">Kirim ke Wadek
                                    1</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- KUMPULAN MODAL PLOTTING PENGUJI (Diletakkan di luar struktur tabel/layout utama) -->
    @php
        // Gunakan ->items() untuk mengambil isi datanya saja dari Paginator
        $semuaUjian = collect()
            ->merge(isset($ujianProposal) ? $ujianProposal->items() : [])
            ->merge(isset($ujianHasil) ? $ujianHasil->items() : [])
            ->merge(isset($ujianSkripsi) ? $ujianSkripsi->items() : []);
    @endphp

    @foreach ($semuaUjian as $item)
        @if ($item->status == 'diajukan')
            <!-- Modal Prodi Penguji untuk ID: {{ $item->id }} -->
            <div class="modal fade" id="modalProdiPenguji{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg text-start">
                    <div class="modal-content rounded-4 shadow">
                        <form action="{{ route('validasi.sk-ujian.prodi', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="fw-bold text-dark">
                                    <i class="bi bi-person-plus-fill text-primary me-2"></i>Tentukan Penguji
                                    (<span class="text-capitalize">Ujian {{ $item->jenis_ujian }}</span>)
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body py-4">
                                <div
                                    class="d-flex justify-content-between align-items-start p-3 bg-light border rounded-3 mb-4">
                                    <div>
                                        <p class="mb-1 text-dark"><strong>Mahasiswa:</strong> {{ $item->nama_mahasiswa }}
                                            ({{ $item->nim }})</p>
                                        <p class="mb-0 text-muted" style="font-size: 14px;"><strong>Judul:</strong>
                                            "{{ $item->judul_skripsi }}"</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal
                                            Ujian</label>
                                        <input type="date" name="tanggal_ujian" class="form-control rounded-3 py-2"
                                            value="{{ $item->tanggal_ujian ? $item->tanggal_ujian->format('Y-m-d') : '' }}"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Jam Ujian</label>
                                        <select name="waktu_ujian" class="form-select rounded-3 py-2" required>
                                            <option value="">-- Pilih Jam Ujian --</option>
                                            <option value="08.00 s/d 09.30"
                                                {{ $item->waktu_ujian == '08.00 s/d 09.30' ? 'selected' : '' }}>Jam Ke-1
                                                (08.00 s/d 09.30)</option>
                                            <option value="09.30 s/d 11.30"
                                                {{ $item->waktu_ujian == '09.30 s/d 11.30' ? 'selected' : '' }}>Jam Ke-2
                                                (09.30 s/d 11.30)</option>
                                            <option value="13.30 s/d 15.00"
                                                {{ $item->waktu_ujian == '13.30 s/d 15.00' ? 'selected' : '' }}>Jam Ke-3
                                                (13.30 s/d 15.00)</option>
                                            <option value="15.30 s/d 17.00"
                                                {{ $item->waktu_ujian == '15.30 s/d 17.00' ? 'selected' : '' }}>Jam Ke-4
                                                (15.30 s/d 17.00)</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>

                                <!-- 1. Ketua Penguji -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Ketua Penguji</label>
                                    <select name="ketua_penguji_id" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Ketua Penguji --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->ketua_penguji_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? $dosen->nama }} || {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 2. Sekretaris -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Sekretaris
                                        Penguji</label>
                                    <select name="sekretaris_id" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Sekretaris --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->sekretaris_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? $dosen->nama }} || {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 3. Anggota 1 (Selalu Muncul) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Anggota Penguji
                                        1</label>
                                    <select name="anggota_1_id" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Anggota 1 --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->anggota_1_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? $dosen->nama }} || {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 4. Anggota 2 (Hanya muncul jika BUKAN proposal) -->
                                @if ($item->jenis_ujian != 'proposal')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Anggota Penguji
                                            2</label>
                                        <select name="anggota_2_id" class="form-select rounded-3 py-2" required>
                                            <option value="">-- Pilih Anggota 2 --</option>
                                            @foreach ($listDosen as $dosen)
                                                <option value="{{ $dosen->id }}"
                                                    {{ $item->anggota_2_id == $dosen->id ? 'selected' : '' }}>
                                                    {{ $dosen->nama_dosen ?? $dosen->nama }} ||
                                                    {{ $dosen->bebanDuaMinggu() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-3 fw-semibold px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4">Teruskan ke
                                    Wadek 1</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection
