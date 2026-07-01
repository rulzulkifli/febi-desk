<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - FEBI Desk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

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

        .nav-link-custom:hover,
        .nav-link-custom.active {
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

        .table> :not(caption)>*>* {
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

        /* Custom Modern Pagination */
        .pagination {
            gap: 8px;
        }

        .pagination .page-item .page-link {
            border: none;
            border-radius: 10px !important;
            padding: 8px 16px;
            color: #64748b;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #059669;
            /* Hijau FEBI Desk */
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2);
        }

        .pagination .page-item .page-link:hover {
            background-color: #f1f5f9;
            color: #059669;
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column p-4 justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2 mb-4 px-2">
                <div class="bg-success text-white rounded-3 p-2 d-flex align-items-center justify-content-center"
                    style="width: 36px; height: 36px;">
                    <i class="bi bi-shield-check-fill"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark m-0">FEBI Desk</h6>
                    <small class="text-muted" style="font-size: 11px;">Panel Internal</small>
                </div>
            </div>

            <hr class="text-muted my-3">

            <nav class="nav flex-column">
                @yield('sidebar_menu')
            </nav>
        </div>

        <div class="bg-light p-3 rounded-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="user-avatar bg-success text-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <h6 class="fw-bold text-dark m-0 text-truncate">{{ Auth::user()->name }}</h6>
                    <small class="text-muted d-block text-truncate text-uppercase"
                        style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
