<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran SK Pembimbing - FEBI Desk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .card-premium {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .accent-bar {
            height: 6px;
            background: linear-gradient(90deg, #059669 0%, #d97706 50%, #047857 100%);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .btn-emerald {
            background-color: #059669;
            color: white;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-emerald:hover {
            background-color: #047857;
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-9">
                <a href="{{ route('portal.index') }}" 
                   class="text-decoration-none text-secondary fw-semibold d-inline-flex align-items-center" 
                   style="transition: all 0.3s ease;" 
                   onmouseover="this.style.transform='translateX(-5px)'; this.style.color='#059669';" 
                   onmouseout="this.style.transform='translateX(0)'; this.classList.replace('text-emerald', 'text-secondary'); this.style.color='';">
                    <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        <div class="text-center mb-5 mt-2">
            <h1 class="fw-bold text-dark tracking-tight">Formulir Pendaftaran SK Pembimbing</h1>
            <p class="text-muted">Ajukan usulan judul skripsi Anda untuk penerbitan SK Pembimbing resmi</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm p-4 rounded-4 mb-4 d-flex align-items-start"
                        role="alert">
                        <svg class="me-3 flex-shrink-0 text-success" width="24" height="24" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h6 class="fw-bold mb-1">Pengajuan Berhasil!</h6>
                            <span class="small">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm p-4 rounded-4 mb-4" role="alert">
                        <h6 class="fw-bold mb-2">Mohon Periksa Kembali Isian Anda:</h6>
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-premium bg-white">
                    <div class="accent-bar"></div>
                    <div class="card-body p-4 p-md-5">

                        <form action="{{ route('sk-pembimbing.store') }}" method="POST" enctype="multipart/form-data"
                            id="formSkPembimbing">
                            @csrf

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="nim" class="form-label fw-semibold text-secondary">Nomor Induk
                                        Mahasiswa (NIM)</label>
                                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                                        class="form-control" placeholder="Contoh: 210201xxxx" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_mahasiswa" class="form-label fw-semibold text-secondary">Nama
                                        Lengkap Mahasiswa</label>
                                    <input type="text" id="nama_mahasiswa" name="nama_mahasiswa"
                                        value="{{ old('nama_mahasiswa') }}" class="form-control"
                                        placeholder="Masukkan nama sesuai KTM..." required>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6"> <label for="prodi"
                                        class="form-label fw-semibold text-secondary">Program Studi</label>
                                    <select id="prodi" name="prodi" class="form-select" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        @foreach ($prodis as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">No. HP WhatsApp Aktif</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                                        placeholder="Contoh: 081234567890" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="judul_skripsi" class="form-label fw-semibold text-secondary">Usulan Judul
                                    Skripsi</label>
                                <textarea id="judul_skripsi" name="judul_skripsi" rows="3" class="form-control"
                                    placeholder="Tuliskan draf judul skripsi Anda yang telah disetujui penasihat akademik..." required>{{ old('judul_skripsi') }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label for="path_file_syarat" class="form-label fw-semibold text-secondary">Dokumen
                                    Persyaratan Gabungan (.pdf)</label>
                                <input type="file" id="path_file_syarat" name="path_file_syarat" class="form-control"
                                    accept="application/pdf" required>
                                <div class="form-text text-muted small mt-2">
                                    * Unggah gabungan berkas persyaratan (KRS, KHS, atau Form Pengajuan) dalam <strong>1
                                        file PDF</strong> (Maksimal ukuran: 200 KB).
                                </div>
                            </div>
                            <div class="d-flex justify-content-end border-top pt-4">
                                <button type="submit" class="btn btn-emerald px-4 shadow-sm" id="btnSubmit">
                                    Kirim Formulir Pengajuan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            // Proteksi sisi klien menggunakan jQuery sebelum file terunggah ke backend
            $('#path_file_syarat').on('change', function() {
                let file = this.files[0];

                if (file) {
                    // 1. Validasi Ekstensi (Wajib PDF)
                    if (file.type !== "application/pdf") {
                        alert("Format berkas salah! Silakan unggah dokumen bertipe PDF.");
                        $(this).val(''); // Reset input file
                        return false;
                    }

                    // 2. Validasi Ukuran Maksimal (2 MB = 2 * 1024 * 1024 Bytes)
                    if (file.size > 2097152) {
                        alert("Berkas terlalu besar! Ukuran maksimal file adalah 2 Megabytes (MB).");
                        $(this).val(''); // Reset input file
                        return false;
                    }
                }
            });

            // Efek loading sederhana saat tombol kirim ditekan
            $('#formSkPembimbing').on('submit', function() {
                $('#btnSubmit').attr('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses Kiriman...'
                );
            });

        });
    </script>
</body>

</html>
