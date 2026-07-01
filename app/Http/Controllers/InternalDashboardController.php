<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalDashboardController extends Controller
{
    public function index()
    {
        // Sementara kita arahkan ke file view yang akan kita buat setelah ini
        return view('internal.dashboard.index');
    }
}
