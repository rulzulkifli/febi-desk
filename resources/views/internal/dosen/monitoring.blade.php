@extends('layouts.internal')

@section('title', 'Monitoring Beban Dosen')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Monitoring Distribusi Tugas Dosen</h2>
            <p class="text-muted mb-0">Pantau intensitas keaktifan dosen sebagai Pembimbing Utama, Pendamping, maupun Penguji
                Sidang.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('internal.dosen.monitoring') }}" data-pjax
        class="row g-3 p-4 bg-light border rounded-4 mb-5 shadow-sm align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control rounded-3" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control rounded-3" value="{{ $endDate }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100 rounded-3 fw-semibold py-2"><i
                    class="bi bi-funnel-fill me-1"></i> Terapkan</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('internal.dosen.monitoring') }}"
                class="btn btn-outline-secondary w-100 rounded-3 fw-semibold py-2">Reset</a>
        </div>
    </form>

    <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-calendar3 fs-5 text-primary"></i>
        <span>Menampilkan akumulasi tugas dari rentang waktu:
            <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> s/d
            <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong></span>
    </div>

    <div class="table-container">
        <div class="p-4 bg-white border-bottom">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-list-stars me-2 text-success"></i> Data Kumulatif Tugas Dosen
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Dosen</th>
                        <th class="text-center">Pembimbing 1 (P1)</th>
                        <th class="text-center">Pembimbing 2 (P2)</th>
                        <th class="text-center">Sebagai Penguji</th>
                        <th class="text-center bg-light fw-bold text-dark">Total Kontribusi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosenPaginated as $index => $dosen)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar bg-success text-white fw-bold">
                                        {{ substr($dosen->nama_dosen ?? $dosen->nama, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $dosen->nama_dosen ?? $dosen->nama }}</div>
                                        <small class="text-muted">NIDN/NIP.
                                            {{ $dosen->nidn ?? ($dosen->nip ?? '-') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge {{ $dosen->p1_count > 0 ? 'bg-success' : 'bg-secondary-subtle text-secondary' }} px-3 py-2 rounded-pill fs-6 fw-semibold">
                                    {{ $dosen->p1_count }} <small style="font-size: 11px;">Mhs</small>
                                </span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge {{ $dosen->p2_count > 0 ? 'bg-primary' : 'bg-secondary-subtle text-secondary' }} px-3 py-2 rounded-pill fs-6 fw-semibold">
                                    {{ $dosen->p2_count }} <small style="font-size: 11px;">Mhs</small>
                                </span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge {{ $dosen->penguji_count > 0 ? 'bg-warning text-dark' : 'bg-secondary-subtle text-secondary' }} px-3 py-2 rounded-pill fs-6 fw-semibold">
                                    {{ $dosen->penguji_count }} <small style="font-size: 11px;">Kali</small>
                                </span>
                            </td>
                            <td class="text-center bg-light fw-bold text-dark fs-5">
                                {{ $dosen->total_kontribusi }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-people d-block fs-1 mb-2 text-black-50"></i> Tidak ada data dosen yang
                                ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $dosenPaginated->links('pagination::bootstrap-5') }}
    </div>
@endsection
