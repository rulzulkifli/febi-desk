@extends('layouts.internal')
@section('title', 'Riwayat ACC')

@section('content')
    <h2 class="fw-bold mb-5">Riwayat Pengesahan</h2>

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('internal.dashboard') }}"><i class="bi bi-inbox-fill me-1"></i> Perlu Diproses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active bg-success" href="{{ route('wadek.riwayat') }}"><i class="bi bi-clock-history me-1"></i> Riwayat ACC</a>
        </li>
    </ul>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Tanggal Disahkan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanSk as $item)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $item->nama_mahasiswa }}</div>
                            <small class="text-muted">NIM. {{ $item->nim }}</small>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 300px;" title="{{ $item->judul_skripsi }}">
                                {{ $item->judul_skripsi }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-calendar-check me-2 text-success"></i>
                                {{ $item->updated_at->format('d M Y') }}
                            </div>
                        </td>
                        <td><span class="badge bg-success text-white px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disahkan</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-archive d-block fs-2 mb-2 text-black-50"></i>
                            Belum ada riwayat pengesahan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5 mb-4">
        {{ $pengajuanSk->links('pagination::bootstrap-5') }}
    </div>
@endsection