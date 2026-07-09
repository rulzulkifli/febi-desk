<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - FEBI Desk</title>
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
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
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2);
        }

        .pagination .page-item .page-link:hover {
            background-color: #f1f5f9;
            color: #059669;
        }

        /* Animasi Transisi Pjax */
        #pjax-container {
            transition: opacity 0.2s ease-in-out;
            opacity: 1;
        }

        #pjax-container.loading {
            opacity: 0.4;
            pointer-events: none;
        }

        /* SweetAlert Font Adjustment */
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
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

            <!-- Sidebar Menu -->
            <nav class="nav flex-column" id="sidebar-nav">
                @php
                    // Ambil peran user yang sedang login dan ubah ke huruf kecil untuk mempermudah pengecekan
                    $peran = strtolower(Auth::user()->peran ?? '');
                    $isAdmin = str_contains($peran, 'admin');
                    $isWadek = str_contains($peran, 'wadek');
                @endphp

                @if ($isAdmin)
                    <div class="text-uppercase text-muted fw-bold mb-2 mt-2 px-3"
                        style="font-size: 10px; letter-spacing: 1px;">Menu Admin</div>

                    <a class="nav-link-custom {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}"
                        href="{{ route('internal.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Antrean Berkas
                    </a>
                    <a class="nav-link-custom" href="#">
                        <i class="bi bi-building"></i> Master Prodi
                    </a>
                @endif

                @if ($isWadek)
                    <div class="text-uppercase text-muted fw-bold mb-2 mt-2 px-3"
                        style="font-size: 10px; letter-spacing: 1px;">Menu Wadek</div>

                    <a class="nav-link-custom {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}"
                        href="{{ route('internal.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard Validasi
                    </a>
                    <a class="nav-link-custom {{ request()->routeIs('internal.wadek.riwayat') ? 'active' : '' }}"
                        href="{{ route('internal.wadek.riwayat') }}">
                        <i class="bi bi-clock-history"></i> Riwayat SK
                    </a>
                @endif

                <div class="text-uppercase text-muted fw-bold mb-2 mt-3 px-3"
                    style="font-size: 10px; letter-spacing: 1px;">Akademik</div>

                <a class="nav-link-custom {{ request()->routeIs('internal.dosen.monitoring') ? 'active' : '' }}"
                    href="{{ route('internal.dosen.monitoring') }}">
                    <i class="bi bi-people-fill"></i> Monitoring Dosen
                </a>

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
            <form action="{{ route('febi.logout') }}" method="POST" id="form-logout">
                @csrf
                <button type="button"
                    class="btn btn-outline-danger btn-sm w-100 rounded-3 fw-semibold py-2 btn-logout">
                    <i class="bi bi-box-arrow-left me-1"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div id="pjax-container">
            @if (session('success'))
                <div id="flash-success" data-message="{{ session('success') }}" style="display: none;"></div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // 1. Inisialisasi Pjax
            // Mengatur link dan form GET (seperti pagination & filter) agar menggunakan AJAX Pjax
            $(document).pjax('a:not([target="_blank"])', '#pjax-container', {
                timeout: 5000,
                fragment: '#pjax-container'
            });

            $(document).on('submit', 'form[method="GET"]', function(event) {
                $.pjax.submit(event, '#pjax-container', {
                    fragment: '#pjax-container'
                });
            });

            // 2. Animasi Transisi Smooth
            $(document).on('pjax:send', function() {
                $('#pjax-container').addClass('loading');
            });

            $(document).on('pjax:complete', function() {
                $('#pjax-container').removeClass('loading');
                initPlugins(); // Re-init komponen JS setiap ganti halaman
            });

            // 3. Fungsi Re-inisialisasi (Dipanggil awal dan setiap Pjax selesai)
            // 3. Fungsi Re-inisialisasi (Dipanggil awal dan setiap Pjax selesai)
            // 3. Fungsi Re-inisialisasi (Dipanggil awal dan setiap Pjax selesai)
            function initPlugins() {
                // Notifikasi Session dengan SweetAlert (Membaca dari elemen tersembunyi)
                let flashSuccess = $('#flash-success');
                if (flashSuccess.length > 0) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: flashSuccess.data('message'),
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });

                    // Hapus elemennya setelah dibaca agar tidak muncul lagi saat Pjax terpanggil
                    flashSuccess.remove();
                }

                // Konfirmasi Hapus Data dengan SweetAlert
                $('.form-delete').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    let form = this;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data dan berkas PDF akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // === TAMBAHAN LOADING ALERT ===
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal
                                .showLoading(); // Memicu animasi loading bawaan SweetAlert2
                                }
                            });

                            // Jalankan submit form setelah loading muncul
                            form.submit();
                        }
                    });
                });
            }

            // Panggil inisialisasi pada saat pertama kali load
            initPlugins();

            // Konfirmasi Logout
            $('.btn-logout').on('click', function() {
                Swal.fire({
                    title: 'Keluar Sistem?',
                    text: "Sesi Anda akan diakhiri.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-logout').submit();
                    }
                });
            });

            // Update Class Active Sidebar saat ganti URL lewat Pjax
            $(document).on('pjax:success', function() {
                let currentUrl = window.location.href;
                $('#sidebar-nav .nav-link-custom').each(function() {
                    $(this).toggleClass('active', $(this).prop('href') === currentUrl);
                });
            });
        });
    </script>
</body>

</html>
