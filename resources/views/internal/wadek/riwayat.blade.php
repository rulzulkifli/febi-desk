@extends('layouts.internal')
@section('title', 'Riwayat ACC')

@section('content')
    <h2 class="fw-bold mb-5">Riwayat Pengesahan</h2>

    <!-- NAVBAR TAB YANG SAMA -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('internal.dashboard') }}"><i class="bi bi-inbox-fill me-1"></i> Perlu Diproses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('wadek.riwayat') }}"><i class="bi bi-clock-history me-1"></i> Riwayat ACC</a>
        </li>
    </ul>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Mahasiswa</th><th>Judul</th><th>Tanggal Disahkan</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($pengajuanSk as $item)
                    <tr>
                        <td>{{ $item->nama_mahasiswa }}</td>
                        <td>{{ $item->judul_skripsi }}</td>
                        <td>{{ $item->updated_at->format('d M Y') }}</td>
                        <td><span class="badge bg-success text-white rounded-pill">Disahkan</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5">Belum ada riwayat pengesahan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paging -->
    <div class="d-flex justify-content-center mt-4">{{ $pengajuanSk->links('pagination::bootstrap-5') }}</div>
@endsection