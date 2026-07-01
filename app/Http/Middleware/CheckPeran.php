<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPeran
{
    // Tambahkan kata 'string' tepat sebelum titik tiga (...)
    public function handle(Request $request, Closure $next, string ...$peranYangBoleh): Response
    {
        // 1. Cek apakah pengguna sudah login atau belum
        if (!Auth::check()) {
            return redirect()->route('febi.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah 'peran' user saat ini ada di dalam daftar peran yang diperbolehkan
        $peranUser = Auth::user()->peran;
        if (in_array($peranUser, $peranYangBoleh)) {
            return $next($request);
        }

        // 3. Jika tidak sesuai perannya, tendang ke halaman utama publik dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
    }
}
