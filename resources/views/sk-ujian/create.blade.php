<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan SK Ujian - FEBI Desk</title>

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

        /* Hidden kelas awal untuk animasi jQuery */
        .js-conditional {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark tracking-tight">Formulir Pengajuan SK Ujian</h1>
            <p class="text-muted">Sistem Administrasi Akademik FEBI Desk</p>
        </div>

        <div class="card card-premium bg-white">
            <div class="accent-bar"></div>
            <div class="card-body p-4 p-md-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sk-ujian.store') }}" method="POST" id="formSkUjian"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label for="nim" class="form-label fw-semibold text-secondary">Nomor Induk Mahasiswa
                                (NIM)</label>
                            <div class="input-group">
                                <input type="text" id="nim" name="nim" class="form-control"
                                    placeholder="Masukkan NIM Anda..." required>
                                <button class="btn btn-outline-secondary px-3" type="button" id="btnCekNim">
                                    <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"
                                        role="status"></span>
                                    Cek NIM
                                </button>
                            </div>
                            <div id="alertContainer" class="mt-2"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="nama_mahasiswa" class="form-label fw-semibold text-secondary">Nama
                                Lengkap</label>
                            <input type="text" id="nama_mahasiswa" name="nama_mahasiswa"
                                class="form-control bg-light" placeholder="Akan terisi otomatis..." required readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="no_hp" class="form-label fw-semibold text-secondary">No. HP /
                                WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control bg-light"
                                placeholder="Akan terisi otomatis..." required readonly>
                        </div>
                    </div>

                    <div id="sectionJalurSistem"
                        class="js-conditional p-4 bg-light border border-success-subtle rounded-4 mb-4">
                        <div class="d-flex align-items-center text-success fw-medium mb-3">
                            <svg class="me-2" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Data SK Pembimbing ditemukan! Dosen pembimbing dikunci otomatis oleh sistem.</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold uppercase">Dosen Pembimbing I</label>
                                <input type="text" id="pembimbing1_nama"
                                    class="form-control bg-white text-dark fw-medium" readonly>
                                <input type="hidden" id="pembimbing1_id" name="pembimbing_1_id">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold uppercase">Dosen Pembimbing II</label>
                                <input type="text" id="pembimbing2_nama"
                                    class="form-control bg-white text-dark fw-medium" readonly>
                                <input type="hidden" id="pembimbing2_id" name="pembimbing_2_id">
                            </div>
                        </div>
                    </div>

                    <div id="sectionJalurTransisi"
                        class="js-conditional p-4 bg-light border border-warning-subtle rounded-4 mb-4">
                        <label class="form-label fw-semibold text-warning-emphasis mb-3">Apakah Anda memiliki lembar
                            fisik SK Pembimbing lama?</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_physical" id="physicalYa"
                                    value="ya">
                                <label class="form-check-label fw-medium text-dark" for="physicalYa">Ya, Saya
                                    Punya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_physical"
                                    id="physicalTidak" value="tidak">
                                <label class="form-check-label fw-medium text-dark" for="physicalTidak">Tidak
                                    Punya</label>
                            </div>
                        </div>

                        <div id="alertLockTransisi"
                            class="js-conditional mt-3 alert alert-danger border-0 rounded-3 mb-0" role="alert">
                            <div class="fw-bold">Akses Terkunci: </div>
                            Wajib mengurus dan menyelesaikan penerbitan SK Pembimbing terlebih dahulu di menu SK
                            Pembimbing sebelum mendaftar ujian.
                        </div>

                        <div id="formManualTransisi"
                            class="js-conditional mt-4 pt-3 border-top border-warning-subtle">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="selectPembimbing1" class="form-label fw-medium text-secondary">Pilih
                                        Pembimbing I (Manual)</label>
                                    <select id="selectPembimbing1" name="pembimbing_1_id_manual" class="form-select">
                                        <option value="">-- Pilih Dosen Pembimbing 1 --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="selectPembimbing2" class="form-label fw-medium text-secondary">Pilih
                                        Pembimbing II (Manual)</label>
                                    <select id="selectPembimbing2" name="pembimbing_2_id_manual" class="form-select">
                                        <option value="">-- Pilih Dosen Pembimbing 2 --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="path_sk_pembimbing_lama"
                                    class="form-label fw-medium text-secondary">Upload Bukti SK Pembimbing Fisik (.pdf)
                                    <span class="text-danger">*</span></label>
                                <input type="file" id="path_sk_pembimbing_lama" name="path_sk_pembimbing_lama"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="sectionDetailUjian" class="js-conditional">
                        <hr class="text-muted my-4">

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="jenis_ujian" class="form-label fw-semibold text-secondary">Jenis
                                    Ujian</label>
                                <select id="jenis_ujian" name="jenis_ujian" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Jenis Ujian --</option>
                                    <option value="proposal">Ujian Proposal Penelitian</option>
                                    <option value="hasil">Ujian Hasil Penelitian</option>
                                    <option value="skripsi">Ujian Sidang Skripsi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="prodi" class="form-label fw-semibold text-secondary">Program
                                    Studi</label>
                                <select id="prodi" name="prodi" class="form-select" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted" id="hintProdi">*Pilih program studi Anda</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="judul_skripsi" class="form-label fw-semibold text-secondary">Judul Skripsi /
                                Tugas Akhir</label>
                            <textarea id="judul_skripsi" name="judul_skripsi" rows="3" class="form-control"
                                placeholder="Tuliskan judul lengkap skripsi Anda..." required></textarea>
                            <small class="text-muted" id="hintJudul">*Otomatis terisi dari data SK Pembimbing</small>
                        </div>

                        <div class="p-4 bg-light rounded-4 mb-4 border border-info-subtle">
                            <h6 class="fw-bold text-dark mb-3">Informasi Pelaksanaan Ujian</h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small text-muted fw-semibold">Ruangan Ujian</label>
                                    <input type="text" class="form-control bg-white text-primary fw-bold"
                                        value="Ruang Ujian Seminar Fakultas" disabled>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-info py-2 mb-0 mt-2 text-sm">
                                        <strong>Catatan:</strong> Tanggal, Waktu Ujian, dan Tim Penguji (Ketua,
                                        Sekretaris, Anggota) akan diplot secara otomatis oleh <strong>Admin
                                            Prodi</strong> setelah pengajuan ini divalidasi.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-2">
                            <button type="submit" class="btn btn-emerald">
                                Kirim Pengajuan SK Ujian
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            // 1. Event Cek NIM dengan jQuery AJAX
            $('#btnCekNim').on('click', function() {
                let nim = $('#nim').val();
                if (nim.length < 3) {
                    alert('Silakan masukkan NIM dengan benar.');
                    return;
                }

                // Jalankan animasi loading spinner
                $('#loadingSpinner').removeClass('d-none');

                $.ajax({
                    url: '/sk-ujian/cek-nim/' + nim,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $('#loadingSpinner').addClass('d-none');

                        // Reset view kondisional awal dan uncheck radio button
                        $('.js-conditional').slideUp();
                        $('input[name="has_physical"]').prop('checked', false);

                        if (res.status === 'success') {
                            // SKENARIO A: Data Ditemukan di Sistem
                            $('#nama_mahasiswa').val(res.data.nama_mahasiswa);

                            // Isi otomatis No HP dan kunci inputnya (Readonly)
                            $('#no_hp').val(res.data.no_hp)
                                .prop('readonly', true)
                                .addClass('bg-light')
                                .attr('placeholder', 'Terisi otomatis...');

                            $('#pembimbing1_nama').val(res.data.pembimbing_1_nama);
                            $('#pembimbing1_id').val(res.data.pembimbing_1_id);
                            $('#pembimbing2_nama').val(res.data.pembimbing_2_nama);
                            $('#pembimbing2_id').val(res.data.pembimbing_2_id);

                            $('#prodi').val(res.data.prodi).css({
                                'pointer-events': 'none',
                                'background-color': '#e9ecef'
                            });
                            $('#hintProdi').text('*Prodi terkunci otomatis dari sistem.');

                            $('#judul_skripsi').val(res.data.judul_skripsi).prop('readonly',
                                true);
                            $('#hintJudul').text('*Judul terkunci otomatis dari sistem.');

                            // Tampilkan section otomatis & form detail ujian
                            $('#sectionJalurSistem').slideDown();
                            $('#sectionDetailUjian').slideDown();

                        } else if (res.status === 'not_found') {
                            // SKENARIO B: Data Tidak Ditemukan (Jalur Transisi)
                            let alertHtml = `
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Oops!</strong> ${res.message}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            `;
                            $('#alertContainer').html(alertHtml);

                            // Reset form nama mahasiswa
                            $('#nama_mahasiswa').val('');
                            $('.js-conditional').slideUp();

                            // Buka field No HP agar mahasiswa bisa ketik manual
                            $('#no_hp').val('')
                                .prop('readonly', false)
                                .removeClass('bg-light')
                                .attr('placeholder', 'Masukkan No. HP/WhatsApp...');

                            // Kosongkan nama & data pembimbing untuk menghindari sisa data sebelumnya
                            $('#pembimbing1_nama').val('');
                            $('#pembimbing1_id').val('');
                            $('#pembimbing2_nama').val('');
                            $('#pembimbing2_id').val('');

                            $('#prodi').val('').css({
                                'pointer-events': 'auto',
                                'background-color': '#fff'
                            });
                            $('#hintProdi').text('*Silakan pilih program studi Anda.');

                            $('#judul_skripsi').val('').prop('readonly', false);
                            $('#hintJudul').text(
                                '*Silakan ketik manual judul skripsi Anda sesuai SK Lama.');

                            // Munculkan pertanyaan SK fisik lama
                            $('#sectionJalurTransisi').slideDown();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loadingSpinner').addClass('d-none');
                        alert('Terjadi kesalahan koneksi sistem: ' + error);
                    }
                });
            });

            // 2. Event Handler Radio Button Jalur Transisi
            $('input[name="has_physical"]').on('change', function() {
                let value = $(this).val();

                if (value === 'ya') {
                    $('#alertLockTransisi').slideUp();
                    $('#formManualTransisi').slideDown();
                    $('#sectionDetailUjian').slideDown();
                } else if (value === 'tidak') {
                    $('#formManualTransisi').slideUp();
                    $('#sectionDetailUjian').slideUp();
                    $('#alertLockTransisi').slideDown();
                }
            });

            // 3. Logika Menghilangkan Kolom Anggota 2 Otomatis (Jika Jenis Ujian = Proposal)
            $('#jenis_ujian').on('change', function() {
                let jenis = $(this).val();

                if (jenis === 'proposal') {
                    $('#containerAnggota2').fadeOut();
                } else {
                    $('#containerAnggota2').fadeIn();
                }
            });

        });
    </script>
</body>

</html>
