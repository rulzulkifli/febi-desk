@extends('layouts.internal')

@section('title', 'Monitoring Jadwal Ujian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Monitoring Jadwal Ujian</h2>
            <p class="text-muted mb-0">Pantau seluruh agenda pelaksanaan ujian mahasiswa prodi yang terdaftar di sistem.</p>
        </div>
        <a href="{{ route('internal.dashboard') }}" class="btn btn-light border rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Ruang Kerja
        </a>
    </div>

    <!-- Panel Filter Pencarian -->
    <form method="GET" action="{{ route('internal.ujian.monitoring') }}" class="row g-3 p-4 bg-white shadow-sm rounded-4 mb-4 border align-items-center">
        
        <!-- Kolom Pencarian Nama/NIM -->
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Nama / NIM..." value="{{ request('search') }}">
            </div>
        </div>

        <!-- Kolom Filter Tanggal -->
        <div class="col-md-3">
            <input type="date" name="tanggal" class="form-control text-muted" value="{{ request('tanggal') }}">
        </div>

        <!-- Kolom Filter Sesi Ujian -->
        <div class="col-md-3">
            <select name="sesi" class="form-select text-muted">
                <option value="">-- Semua Sesi Ujian --</option>
                <option value="08.00 s/d 09.30" {{ request('sesi') == '08.00 s/d 09.30' ? 'selected' : '' }}>Sesi 1 (08.00 - 09.30)</option>
                <option value="09.30 s/d 11.30" {{ request('sesi') == '09.30 s/d 11.30' ? 'selected' : '' }}>Sesi 2 (09.30 - 11.30)</option>
                <option value="13.30 s/d 15.00" {{ request('sesi') == '13.30 s/d 15.00' ? 'selected' : '' }}>Sesi 3 (13.30 - 15.00)</option>
                <option value="15.30 s/d 17.00" {{ request('sesi') == '15.30 s/d 17.00' ? 'selected' : '' }}>Sesi 4 (15.30 - 17.00)</option>
            </select>
        </div>

        <!-- Kolom Tombol Aksi -->
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-50" title="Cari/Filter"><i class="bi bi-search"></i></button>
            <a href="{{ route('internal.ujian.monitoring') }}" class="btn btn-outline-secondary w-50" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
        
    </form>

    @php
        $tabsMonitoring = [
            'proposal' => ['title' => 'Ujian Proposal', 'data' => $ujianProposal, 'badge' => $badgeProposal, 'avatarBg' => 'bg-danger-subtle text-danger'],
            'hasil'    => ['title' => 'Ujian Hasil', 'data' => $ujianHasil, 'badge' => $badgeHasil, 'avatarBg' => 'bg-warning-subtle text-warning'],
            'skripsi'  => ['title' => 'Ujian Skripsi', 'data' => $ujianSkripsi, 'badge' => $badgeSkripsi, 'avatarBg' => 'bg-success-subtle text-success']
        ];
    @endphp

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill shadow-sm border" id="monitoringTabs" role="tablist" style="width: fit-content;">
        @foreach($tabsMonitoring as $key => $meta)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }} fw-bold px-4 rounded-pill d-flex align-items-center" 
                        id="{{ $key }}-monitor-tab" data-bs-toggle="pill" data-bs-target="#monitor-{{ $key }}" type="button" role="tab">
                    {{ $meta['title'] }}
                    @if($meta['badge'] > 0)
                        <span class="badge bg-danger ms-2 rounded-pill text-white">{{ $meta['badge'] }}</span>
                    @endif
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="monitoringTabsContent">
        @foreach($tabsMonitoring as $key => $meta)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="monitor-{{ $key }}" role="tabpanel">
                <div class="table-container border shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Kontak (WA)</th>
                                    <th>Waktu & Pelaksanaan</th>
                                    <th>Tim Penguji Mandat</th>
                                    <th>Status Terkini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($meta['data'] as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-avatar {{ $meta['avatarBg'] }} fw-bold">
                                                    {{ substr($item->nama_mahasiswa, 0, 2) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">{{ $item->nama_mahasiswa }}</div>
                                                    <small class="text-muted">NIM. {{ $item->nim }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $item->programStudi->nama_prodi ?? 'Tidak Diketahui' }}</div>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_hp) }}" target="_blank" class="text-success text-decoration-none fw-medium">
                                                <i class="bi bi-whatsapp"></i> {{ $item->no_hp }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">
                                                <i class="bi bi-calendar-event text-primary me-1"></i> 
                                                {{ $item->tanggal_ujian ? $item->tanggal_ujian->translatedFormat('d F Y') : '-' }}
                                            </div>
                                            <small class="text-muted d-block mt-1"><i class="bi bi-clock me-1"></i> Sesi: {{ $item->waktu_ujian ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1" style="font-size: 12px; font-weight: 500;">
                                                @if ($item->ketuaPenguji)
                                                    <span class="text-dark"><strong class="text-danger">K:</strong> {{ $item->ketuaPenguji->nama_dosen ?? $item->ketuaPenguji->nama }}</span>
                                                @endif
                                                @if ($item->sekretaris)
                                                    <span class="text-dark"><strong class="text-warning text-darken">S:</strong> {{ $item->sekretaris->nama_dosen ?? $item->sekretaris->nama }}</span>
                                                @endif
                                                @if ($item->anggota1)
                                                    <span class="text-dark"><strong class="text-primary">A1:</strong> {{ $item->anggota1->nama_dosen ?? $item->anggota1->nama }}</span>
                                                @endif
                                                @if ($item->anggota2)
                                                    <span class="text-dark"><strong class="text-info text-darken">A2:</strong> {{ $item->anggota2->nama_dosen ?? $item->anggota2->nama }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->status == 'persetujuan_wadek')
                                                <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Proses Wadek</span>
                                            @elseif($item->status == 'siap_dicetak' || $item->status == 'selesai')
                                                <span class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">Terjadwal</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary fw-semibold px-3 py-2 rounded-pill">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-calendar-x d-block fs-2 mb-2 text-black-50"></i> Belum ada agenda pelaksanaan aktif untuk kategori ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex flex-column align-items-center mt-4 mb-4">
                    {{ $meta['data']->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endforeach
    </div>
@endsection