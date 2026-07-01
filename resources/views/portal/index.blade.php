<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Layanan Mahasiswa - FEBI Desk</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: radial-gradient(circle at top right, #ecfdf5 0%, transparent 20%), radial-gradient(circle at bottom left, #fffbeb 0%, transparent 20%);
            min-height: 100vh;
        }
        
        .service-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            color: inherit;
            display: block;
            border: 1px solid #f1f5f9;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(5, 150, 105, 0.1);
            border-color: #d1fae5;
        }
        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .icon-emerald { background: #d1fae5; color: #059669; }
        .icon-amber { background: #fef3c7; color: #d97706; }
        
        /* Live Board Section */
        .board-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.04);
            border: 1px solid #ffffff;
        }
        
        .nav-pills .nav-link {
            color: #64748b;
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s;
        }
        .nav-pills .nav-link.active {
            background-color: #059669;
            color: white;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }
        
        .badge-status {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        
        .table > :not(caption) > * > * {
            padding: 1rem 1rem;
            background-color: transparent;
            border-bottom-color: #f1f5f9;
        }
    </style>
</head>
<body>

@php
    function getStatusBadge($status) {
        return match($status) {
            'diajukan' => '<span class="badge-status bg-secondary text-white">Diajukan</span>',
            'dicek_prodi' => '<span class="badge-status" style="background:#fef3c7; color:#d97706;">Diperiksa Prodi</span>',
            'persetujuan_wadek' => '<span class="badge-status" style="background:#e0f2fe; color:#0284c7;">Persetujuan Wadek</span>',
            'siap_dicetak' => '<span class="badge-status" style="background:#dbeafe; color:#1d4ed8;">Siap Dicetak</span>',
            default => '<span class="badge-status bg-dark text-white">Unknown</span>',
        };
    }
@endphp

<div class="container py-5">
    
    <div class="text-center mb-5 mt-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-emerald-100 text-emerald-800 px-3 py-1 rounded-pill fw-bold small mb-3" style="background:#d1fae5; color:#065f46;">
            FEBI DESK
        </div>
        <h1 class="fw-bolder text-dark mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">Portal Layanan Akademik</h1>
        <p class="text-secondary fs-5 mx-auto" style="max-width: 600px;">Pilih jenis layanan untuk mengajukan surat keputusan, atau pantau status antrean berkas yang sedang diproses.</p>
    </div>

    <div class="row g-4 justify-content-center mb-5 pb-3">
        <div class="col-md-5 col-lg-4">
            <a href="{{ route('sk-pembimbing.create') }}" class="service-card p-4 p-lg-5 h-100">
                <div class="icon-box icon-emerald"><i class="bi bi-file-earmark-person"></i></div>
                <h4 class="fw-bold mb-2">Ajukan SK Pembimbing</h4>
                <p class="text-muted mb-0 small">Daftarkan usulan judul skripsi dan dapatkan SK pembimbing Anda.</p>
            </a>
        </div>
        <div class="col-md-5 col-lg-4">
            <a href="{{ route('sk-ujian.create') }}" class="service-card p-4 p-lg-5 h-100">
                <div class="icon-box icon-amber"><i class="bi bi-mortarboard"></i></div>
                <h4 class="fw-bold mb-2">Ajukan SK Ujian</h4>
                <p class="text-muted mb-0 small">Daftarkan diri Anda untuk pelaksanaan Ujian Proposal, Hasil, atau Skripsi.</p>
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="board-section p-4 p-md-5">
                <div class="text-center mb-4">
                    <h5 class="fw-bold"><i class="bi bi-activity text-success me-2"></i> Papan Pemantauan Berkas Aktif</h5>
                    <p class="text-muted small">Menampilkan daftar pengajuan yang sedang diproses oleh sistem.</p>
                </div>
                
                <ul class="nav nav-pills justify-content-center mb-4" id="boardTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pembimbing-tab" data-bs-toggle="pill" data-bs-target="#pembimbing" type="button" role="tab" aria-controls="pembimbing" aria-selected="true">
                            Antrean SK Pembimbing
                        </button>
                    </li>
                    <li class="nav-item ms-2" role="presentation">
                        <button class="nav-link" id="ujian-tab" data-bs-toggle="pill" data-bs-target="#ujian" type="button" role="tab" aria-controls="ujian" aria-selected="false">
                            Antrean SK Ujian
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="boardTabContent">
                    
                    <div class="tab-pane fade show active" id="pembimbing" role="tabpanel" aria-labelledby="pembimbing-tab">
                        @if($skPembimbingAktif->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle fs-1 text-success mb-3 d-block"></i>
                                Belum ada antrean pengajuan SK Pembimbing saat ini.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-muted small">
                                        <tr>
                                            <th>TGL UPDATE</th>
                                            <th>NIM</th>
                                            <th>NAMA MAHASISWA</th>
                                            <th class="text-center">STATUS SAAT INI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skPembimbingAktif as $item)
                                        <tr>
                                            <td class="small text-muted">{{ $item->updated_at->format('d M Y - H:i') }}</td>
                                            <td class="fw-bold text-dark">{{ $item->nim }}</td>
                                            <td>
                                                <div class="fw-medium">{{ $item->nama_mahasiswa }}</div>
                                                <div class="text-muted small text-truncate" style="max-width: 250px;" title="{{ $item->judul_skripsi }}">{{ $item->judul_skripsi }}</div>
                                            </td>
                                            <td class="text-center">{!! getStatusBadge($item->status) !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="ujian" role="tabpanel" aria-labelledby="ujian-tab">
                        @if($skUjianAktif->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle fs-1 text-success mb-3 d-block"></i>
                                Belum ada antrean pengajuan SK Ujian saat ini.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-muted small">
                                        <tr>
                                            <th>TGL UPDATE</th>
                                            <th>NIM</th>
                                            <th>NAMA & JENIS UJIAN</th>
                                            <th class="text-center">STATUS SAAT INI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skUjianAktif as $item)
                                        <tr>
                                            <td class="small text-muted">{{ $item->updated_at->format('d M Y - H:i') }}</td>
                                            <td class="fw-bold text-dark">{{ $item->nim }}</td>
                                            <td>
                                                <div class="fw-medium">{{ $item->nama_mahasiswa }}</div>
                                                <div class="text-muted small">Ujian <span class="text-capitalize">{{ $item->jenis_ujian }}</span></div>
                                            </td>
                                            <td class="text-center">{!! getStatusBadge($item->status) !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>