<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Internal - FEBI Desk</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            width: 260px;
            z-index: 100;
        }
        .main-content {
            margin-left: 260px;
            padding: 40px;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #64748b;
            font-weight: 500;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: #f0fdf4;
            color: #059669;
            font-weight: 600;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }
        .icon-shape {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .table-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .table > :not(caption) > * > * {
            padding: 16px 24px;
            border-bottom-color: #f1f5f9;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .btn-action {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-4 justify-content-between">
    <div>
        <div class="d-flex align-items-center gap-2 mb-4 px-2">
            <div class="bg-success text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-shield-check-fill"></i>
            </div>
            <div>
                <h6 class="fw-bold text-dark m-0">FEBI Desk</h6>
                <small class="text-muted" style="font-size: 11px;">Panel Internal v2.0</small>
            </div>
        </div>

        <hr class="text-muted my-3">

        <nav class="nav flex-column">
            <a class="nav-link-custom active" href="#"><i class="bi bi-grid-1x2-fill"></i> Antrean Berkas</a>
            <a class="nav-link-custom" href="#"><i class="bi bi-file-earmark-person"></i> Validasi SK</a>
            <a class="nav-link-custom" href="#"><i class="bi bi-people"></i> Data Dosen</a>
        </nav>
    </div>

    <div class="bg-light p-3 rounded-4">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="user-avatar bg-success text-white">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <h6 class="fw-bold text-dark m-0 text-truncate">{{ Auth::user()->name }}</h6>
                <small class="text-muted d-block text-truncate text-uppercase" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">
                    {{ str_replace('_', ' ', Auth::user()->peran) }}
                </small>
            </div>
        </div>
        <form action="{{ route('febi.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-3 fw-semibold py-2">
                <i class="bi bi-box-arrow-left me-1"></i> Keluar Sistem
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Daftar Pengajuan Masuk</h2>
            <p class="text-muted mb-0">Selamat datang kembali! Periksa berkas mahasiswa yang membutuhkan tindakan Anda.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card-stat p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Menunggu Pengecekan</span>
                        <h3 class="fw-bold text-dark m-0">12 <span class="text-muted font-normal" style="font-size: 14px;">berkas</span></h3>
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
                        <span class="text-muted small fw-semibold d-block mb-1">Butuh ACC Wadek</span>
                        <h3 class="fw-bold text-dark m-0">5 <span class="text-muted font-normal" style="font-size: 14px;">berkas</span></h3>
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
                        <span class="text-muted small fw-semibold d-block mb-1">Selesai Bulan Ini</span>
                        <h3 class="fw-bold text-dark m-0">87 <span class="text-muted font-normal" style="font-size: 14px;">berkas</span></h3>
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
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-list-task me-2 text-success"></i> Antrean Pengajuan Berkas</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Jenis Layanan</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan Hak Akses</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar bg-success-subtle text-success fw-bold">AM</div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">Ahmad Maulana</div>
                                    <small class="text-muted">NIM. 2101020034</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">Manajemen Bisnis Syariah</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border p-2 rounded-3"><i class="bi bi-file-earmark-person-fill text-success me-1"></i> SK Pembimbing</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2 rounded-pill">Diajukan</span>
                        </td>
                        <td class="text-end">
                            @if(Auth::user()->peran == 'admin_prodi')
                                <a href="#" class="btn btn-success btn-action shadow-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Plotting Dosen
                                </a>
                            @else
                                <button class="btn btn-light text-muted btn-action border" disabled>
                                    <i class="bi bi-lock-fill me-1"></i> Bagian Admin
                                </button>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar bg-warning-subtle text-warning fw-bold">SR</div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">Siti Rahmawati</div>
                                    <small class="text-muted">NIM. 2101010087</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">Ekonomi Syariah</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border p-2 rounded-3"><i class="bi bi-file-earmark-text-fill text-primary me-1"></i> SK Ujian Hasil</span>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">Persetujuan Wadek</span>
                        </td>
                        <td class="text-end">
                            @if(Auth::user()->peran == 'wadek_1')
                                <a href="#" class="btn btn-primary btn-action shadow-sm">
                                    <i class="bi bi-shield-check me-1"></i> Validasi & ACC
                                </a>
                            @else
                                <button class="btn btn-light text-muted btn-action border" disabled>
                                    <i class="bi bi-hourglass-top me-1"></i> Menunggu Wadek
                                </button>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>