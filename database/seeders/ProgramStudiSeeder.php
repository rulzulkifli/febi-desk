<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_prodi' => '01',
                'singkatan'  => 'ESY',
                'nama_prodi' => 'Ekonomi Syariah',
                'jenjang'    => 'S1',
                'akreditasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_prodi' => '02',
                'singkatan'  => 'PBS',
                'nama_prodi' => 'Perbankan Syariah',
                'jenjang'    => 'S1',
                'akreditasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_prodi' => '03',
                'singkatan'  => 'MBS',
                'nama_prodi' => 'Manajemen Syariah',
                'jenjang'    => 'S1',
                'akreditasi' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data ke dalam tabel
        DB::table('program_studi')->insert($data);
    }
}
