<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Internal Panel - FEBI Desk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            background: #ffffff;
            width: 100%;
            max-width: 420px;
        }
        .accent-bar {
            height: 6px;
            background: linear-gradient(90deg, #059669 0%, #d97706 50%, #047857 100%);
        }
        .btn-premium {
            background: #059669;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-premium:hover {
            background: #047857;
            color: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 11px 16px;
            border-color: #e2e8f0;
        }
        .form-control:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
    </style>
</head>
<body>

<div class="card-login">
    <div class="accent-bar"></div>
    <div class="p-5">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark mb-1">FEBI Desk</h4>
            <p class="text-muted small">Panel Autentikasi Internal Kampus</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success small border-0 py-2.5" role="alert">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger small border-0 py-2.5" role="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('febi.login.proses') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-semibold">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@domain.com" required autofocus>
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-secondary small fw-semibold">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-premium w-100 shadow-sm">Masuk Panel</button>
        </form>
    </div>
</div>

</body>
</html>