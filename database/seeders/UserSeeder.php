<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Simulasi untuk Admin Prodi
        User::create([
            'name' => 'Admin Prodi FEBI',
            'email' => 'adminprodi@febi.com',
            'password' => Hash::make('password123'), // Password untuk login nanti
            'peran' => 'admin_prodi', // Menyesuaikan kolom 'peran' milikmu
        ]);

        // 2. Membuat Akun Simulasi untuk Wakil Dekan 1 (Wadek 1)
        User::create([
            'name' => 'Dr. H. Wadek Satu, M.E.',
            'email' => 'wadek1@febi.com',
            'password' => Hash::make('password123'), // Password untuk login nanti
            'peran' => 'wadek_1', // Menyesuaikan kolom 'peran' milikmu
        ]);
    }
}
