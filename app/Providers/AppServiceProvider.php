<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // 1. Tambahkan ini
use App\Models\ProgramStudi;         // 2. Tambahkan modelnya di sini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 3. Suntikkan data secara otomatis ke view yang dipilih
        View::composer(
            ['sk_ujian.create', 'sk-pembimbing.create'], // Sebutkan nama-nama file blade kamu di sini
            function ($view) {
                $view->with('program_studi', ProgramStudi::all());
            }
        );
    }
}
