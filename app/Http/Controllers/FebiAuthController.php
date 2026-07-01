<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FebiAuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        // Jika sudah terlanjur login, langsung lempar ke dashboard internal
        if (Auth::check()) {
            return redirect()->route('internal.dashboard');
        }
        return view('internal.auth.login');
    }

    // 2. Memproses data input login (Email & Password)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba mencocokkan email & password ke database
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Jika berhasil, langsung arahkan ke halaman dashboard internal febi
            return redirect()->intended(route('internal.dashboard'))
                ->with('success', 'Selamat datang kembali!');
        }

        // Jika email atau password salah, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 3. Memproses keluar dari sistem (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('febi.login')->with('success', 'Berhasil keluar sistem.');
    }
}
