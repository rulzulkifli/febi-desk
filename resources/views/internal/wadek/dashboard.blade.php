@extends('layouts.internal')

@section('title', 'Dashboard Wakil Dekan 1')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Ruang Kerja Wakil Dekan 1</h2>
            <p class="text-muted mb-0">Pantau dan validasi antrean pengajuan SK Pembimbing dan SK Ujian Mahasiswa.</p>
        </div>
    </div>

    {{-- KODE CARD MONITORING MULAI DARI SINI --}}
    <div class="row mb-4">
        {{-- Card Butuh ACC --}}
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 h-100"
                style="background: linear-gradient(135deg, #fff3cd 0%, #ffecb5 100%);">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Menunggu ACC Anda</h6>
                        <h3 class="fw-bolder text-warning-emphasis mb-0">{{ $butuhAccWadek }} <span
                                class="fs-6 fw-normal text-dark">Berkas</span></h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card ACC Bulan Ini --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100"
                style="background: linear-gradient(135deg, #d1e7dd 0%, #badbcc 100%);">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-check2-all fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Total ACC (Bulan Ini)</h6>
                        <h3 class="fw-bolder text-success-emphasis mb-0">{{ $accBulanIni }} <span
                                class="fs-6 fw-normal text-dark">Berkas</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- KODE CARD MONITORING SELESAI --}}

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill shadow-sm border" id="wadekTabs" role="tablist"
        style="width: fit-content;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill d-flex align-items-center" id="pembimbing-tab"
                data-bs-toggle="pill" data-bs-target="#pembimbing" type="button" role="tab">
                <i class="bi bi-person-lines-fill me-2"></i> ACC Pembimbing
                @if ($pengajuanSkPembimbing->total() > 0)
                    <span class="badge bg-danger ms-2 rounded-pill shadow-sm">{{ $pengajuanSkPembimbing->total() }}</span>
                @endif
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill d-flex align-items-center" id="penguji-tab"
                data-bs-toggle="pill" data-bs-target="#penguji" type="button" role="tab">
                <i class="bi bi-file-earmark-person me-2"></i> ACC Penguji
                @if (isset($totalUjianWadek) && $totalUjianWadek > 0)
                    <span class="badge bg-danger ms-2 rounded-pill shadow-sm">{{ $totalUjianWadek }}</span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="wadekTabsContent">

        <div class="tab-pane fade show active" id="pembimbing" role="tabpanel">
            <div class="table-container border-top-0">
                <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between rounded-top">
                    <h5 class="fw-bold text-dark m-0"><i class="bi bi-list-task me-2 text-success"></i> Antrean SK
                        Pembimbing</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Mahasiswa (Pembimbing)</th>
                                <th>Program Studi</th>
                                <th>Tanggal Diajukan</th>
                                <th>No HP</th>
                                <th class="text-end">Aksi</th>
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
                                                            style="font-size: 9px;">
                                                            {{ $item->pembimbing1->bebanDuaMinggu() }}
                                                        </span>
                                                    </div>
                                                @endif
                                                @if ($item->pembimbing2)
                                                    <div class="text-primary" style="font-size: 12px; font-weight: 500;">
                                                        <i class="bi bi-person-badge"></i> P2:
                                                        {{ $item->pembimbing2->nama_dosen ?? ($item->pembimbing2->nama ?? $item->pembimbing2->name) }}
                                                        <span class="badge bg-secondary-subtle text-secondary ms-1"
                                                            style="font-size: 9px;">
                                                            {{ $item->pembimbing2->bebanDuaMinggu() }}
                                                        </span>
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
                                        <div class="text-muted small">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}"
                                            target="_blank" class="text-success text-decoration-none">
                                            <i class="bi bi-whatsapp"></i> {{ $item->no_hp }}
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-success btn-action shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalProsesPembimbing{{ $item->id }}">
                                            <i class="bi bi-check-circle me-1"></i> Proses ACC
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="bi bi-folder-check d-block fs-2 mb-2 text-black-50"></i> Belum ada antrean
                                        SK Pembimbing.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex flex-column align-items-center mt-4 mb-4">
                {{ $pengajuanSkPembimbing->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="tab-pane fade" id="penguji" role="tabpanel">

            @php
                $ujianTabs = [
                    'proposal' => [
                        'title' => 'Ujian Proposal',
                        'data' => $ujianProposalWadek ?? collect(),
                        'badge' => $badgeProposalWadek ?? 0,
                    ],
                    'hasil' => [
                        'title' => 'Ujian Hasil',
                        'data' => $ujianHasilWadek ?? collect(),
                        'badge' => $badgeHasilWadek ?? 0,
                    ],
                    'skripsi' => [
                        'title' => 'Ujian Skripsi',
                        'data' => $ujianSkripsiWadek ?? collect(),
                        'badge' => $badgeSkripsiWadek ?? 0,
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
                                            <th>Mahasiswa (Penguji)</th>
                                            <th>Program Studi</th>
                                            <th>Tanggal Diajukan</th>
                                            <th>No HP</th>
                                            <th class="text-end">Aksi</th>
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

                                                            <div class="mt-1 d-flex flex-column gap-1"
                                                                style="font-size: 12px; font-weight: 500;">
                                                                @if ($item->ketuaPenguji)
                                                                    <span class="text-danger"><i
                                                                            class="bi bi-person-badge-fill"></i> Ketua:
                                                                        {{ $item->ketuaPenguji->nama_dosen ?? $item->ketuaPenguji->nama }}<span
                                                                            class="badge bg-secondary-subtle text-secondary ms-1"
                                                                            style="font-size: 9px;">
                                                                            {{ $item->ketuaPenguji->bebanDuaMinggu() }}
                                                                        </span></span>
                                                                @endif
                                                                @if ($item->sekretaris)
                                                                    <span class="text-warning text-darken"><i
                                                                            class="bi bi-person-badge"></i> Sek:
                                                                        {{ $item->sekretaris->nama_dosen ?? $item->sekretaris->nama }}<span
                                                                            class="badge bg-secondary-subtle text-secondary ms-1"
                                                                            style="font-size: 9px;">
                                                                            {{ $item->sekretaris->bebanDuaMinggu() }}
                                                                        </span></span>
                                                                @endif
                                                                @if ($item->anggota1)
                                                                    <span class="text-primary"><i
                                                                            class="bi bi-person"></i> A1:
                                                                        {{ $item->anggota1->nama_dosen ?? $item->anggota1->nama }}<span
                                                                            class="badge bg-secondary-subtle text-secondary ms-1"
                                                                            style="font-size: 9px;">
                                                                            {{ $item->anggota1->bebanDuaMinggu() }}
                                                                        </span></span>
                                                                @endif
                                                                @if ($item->anggota2)
                                                                    <span class="text-info text-darken"><i
                                                                            class="bi bi-person"></i> A2:
                                                                        {{ $item->anggota2->nama_dosen ?? $item->anggota2->nama }}<span
                                                                            class="badge bg-secondary-subtle text-secondary ms-1"
                                                                            style="font-size: 9px;">
                                                                            {{ $item->anggota2->bebanDuaMinggu() }}
                                                                        </span></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-medium text-dark">
                                                        {{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}</div>
                                                </td>
                                                <td>
                                                    <div class="text-muted small"><i
                                                            class="bi bi-calendar-event me-1"></i>{{ $item->created_at->format('d M Y') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}"
                                                        target="_blank" class="text-success text-decoration-none">
                                                        <i class="bi bi-whatsapp"></i> {{ $item->no_hp }}
                                                    </a>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-primary btn-action shadow-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalProsesPenguji{{ $item->id }}">
                                                        <i class="bi bi-check-circle me-1"></i> Proses ACC
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-5">
                                                    <i class="bi bi-folder-check d-block fs-2 mb-2 text-black-50"></i>
                                                    Belum ada antrean untuk {{ $tab['title'] }}.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-center mt-4 mb-4">
                            {{ $tab['data']->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 1. Modal Proses ACC Pembimbing --}}
    @foreach ($pengajuanSkPembimbing as $item)
        <div class="modal fade" id="modalProsesPembimbing{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg text-start">
                <div class="modal-content rounded-4 shadow">
                    <form action="{{ route('validasi.sk-pembimbing.wadek', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header border-0 pb-0">
                            <h5 class="fw-bold text-dark"><i
                                    class="bi bi-person-check-fill text-success me-2"></i>Validasi Pembimbing</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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

                            <div class="alert alert-info border-0 rounded-3 small">
                                <i class="bi bi-info-circle-fill me-2"></i> Wadek 1 dapat menyesuaikan formasi dosen
                                sebelum mengesahkan dokumen.
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Pembimbing Utama
                                    (P1)</label>
                                <select name="pembimbing_1_id" class="form-select rounded-3 py-2" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($listDosen as $dosen)
                                        <option value="{{ $dosen->id }}"
                                            {{ isset($item->pembimbing_1_id) && $item->pembimbing_1_id == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                            {{ $dosen->bebanDuaMinggu() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-bold small text-muted text-uppercase">Pembimbing Pendamping
                                    (P2)</label>
                                <select name="pembimbing_2_id" class="form-select rounded-3 py-2" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($listDosen as $dosen)
                                        <option value="{{ $dosen->id }}"
                                            {{ isset($item->pembimbing_2_id) && $item->pembimbing_2_id == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen ?? ($dosen->nama ?? $dosen->name) }}
                                            {{ $dosen->bebanDuaMinggu() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 justify-content-between">
                            <button type="button" class="btn btn-outline-danger rounded-3 fw-semibold px-4"
                                data-bs-toggle="modal" data-bs-target="#modalTolakPembimbing{{ $item->id }}">
                                Tolak / Kembalikan
                            </button>
                            <div>
                                <button type="button" class="btn btn-light rounded-3 fw-semibold px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-3 fw-semibold px-4">ACC & Siap
                                    Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sub-Modal Tolak Pembimbing --}}
        <div class="modal fade" id="modalTolakPembimbing{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <form action="{{ route('validasi.sk-pembimbing.tolak', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header border-0 pb-0">
                            <h5 class="fw-bold text-danger"><i class="bi bi-x-circle-fill me-2"></i>Kembalikan ke Admin
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body py-4">
                            <label class="form-label fw-bold">Catatan Penolakan / Revisi:</label>
                            <textarea name="catatan_penolakan" class="form-control rounded-3" rows="3" required
                                placeholder="Contoh: Formasi dosen ini sudah penuh, tolong ganti dosen pembimbing 2..."></textarea>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-3"
                                data-bs-target="#modalProsesPembimbing{{ $item->id }}"
                                data-bs-toggle="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-3">Kirim Catatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- 2. Modal Proses ACC Penguji --}}
    @php
        $semuaUjianWadek = collect()
            ->merge(isset($ujianProposalWadek) ? $ujianProposalWadek->items() : [])
            ->merge(isset($ujianHasilWadek) ? $ujianHasilWadek->items() : [])
            ->merge(isset($ujianSkripsiWadek) ? $ujianSkripsiWadek->items() : []);
    @endphp

    @foreach ($semuaUjianWadek as $item)
        <div class="modal fade" id="modalProsesPenguji{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg text-start">
                <div class="modal-content rounded-4 shadow">
                    <form action="{{ route('validasi.sk-ujian.wadek', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header border-0 pb-0">
                            <h5 class="fw-bold text-dark">
                                <i class="bi bi-person-check-fill text-primary me-2"></i>Validasi Penguji
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

                            <div class="alert alert-info border-0 rounded-3 small">
                                <i class="bi bi-info-circle-fill me-2"></i> Wadek 1 dapat menyesuaikan Jadwal dan Formasi
                                tim penguji sebelum pengesahan (ACC).
                            </div>

                            {{-- EDIT TANGGAL DAN WAKTU --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Ujian</label>
                                    <input type="date" name="tanggal_ujian" class="form-control rounded-3 py-2" 
                                        value="{{ $item->tanggal_ujian ? \Carbon\Carbon::parse($item->tanggal_ujian)->format('Y-m-d') : '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Jam Ujian</label>
                                    <select name="waktu_ujian" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Jam Ujian --</option>
                                        <option value="08.00 s/d 09.30" {{ $item->waktu_ujian == '08.00 s/d 09.30' ? 'selected' : '' }}>Jam Ke-1 (08.00 s/d 09.30)</option>
                                        <option value="09.30 s/d 11.30" {{ $item->waktu_ujian == '09.30 s/d 11.30' ? 'selected' : '' }}>Jam Ke-2 (09.30 s/d 11.30)</option>
                                        <option value="13.30 s/d 15.00" {{ $item->waktu_ujian == '13.30 s/d 15.00' ? 'selected' : '' }}>Jam Ke-3 (13.30 s/d 15.00)</option>
                                        <option value="15.30 s/d 17.00" {{ $item->waktu_ujian == '15.30 s/d 17.00' ? 'selected' : '' }}>Jam Ke-4 (15.30 s/d 17.00)</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="my-4 text-muted">

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

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Anggota Penguji 1</label>
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

                            @if ($item->jenis_ujian != 'proposal')
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted text-uppercase">Anggota Penguji
                                        2</label>
                                    <select name="anggota_2_id" class="form-select rounded-3 py-2" required>
                                        <option value="">-- Pilih Anggota 2 --</option>
                                        @foreach ($listDosen as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ $item->anggota_2_id == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen ?? $dosen->nama }} || {{ $dosen->bebanDuaMinggu() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                        {{-- FOOTER MODAL DIUBAH AGAR ADA TOMBOL TOLAK --}}
                        <div class="modal-footer border-0 pt-0 justify-content-between">
                            <button type="button" class="btn btn-outline-danger rounded-3 fw-semibold px-4"
                                data-bs-toggle="modal" data-bs-target="#modalTolakPenguji{{ $item->id }}">
                                Tolak / Kembalikan
                            </button>
                            <div>
                                <button type="button" class="btn btn-light rounded-3 fw-semibold px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4">ACC & Siap
                                    Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TAMBAHAN: Sub-Modal Tolak Penguji --}}
        <div class="modal fade" id="modalTolakPenguji{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <form action="{{ route('validasi.sk-ujian.tolak', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header border-0 pb-0">
                            <h5 class="fw-bold text-danger"><i class="bi bi-x-circle-fill me-2"></i>Kembalikan ke Admin
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body py-4">
                            <label class="form-label fw-bold">Catatan Penolakan / Revisi:</label>
                            <textarea name="catatan_penolakan" class="form-control rounded-3" rows="3" required
                                placeholder="Contoh: Jadwal bentrok, mohon disesuaikan ulang tanggal dan waktu ujiannya..."></textarea>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-3"
                                data-bs-target="#modalProsesPenguji{{ $item->id }}"
                                data-bs-toggle="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-3">Kirim Catatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
