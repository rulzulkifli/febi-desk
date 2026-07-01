<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $dosen = [
            ['nip' => '197308171998031002', 'nama_dosen' => 'Prof. Dr. Husain Insawan, M.Ag.'],
            ['nip' => '197508152009011011', 'nama_dosen' => 'Dr. K.H. Muhammad Hadi, M.H.I.'],
            ['nip' => '198801082018011001', 'nama_dosen' => 'Dr. Abdul Wahid Mongkito, S.Si., M.E.I.'],
            ['nip' => '197608062005012006', 'nama_dosen' => 'Nurjannah, S.Kom., M.Pd.'],
            ['nip' => '198006272009011008', 'nama_dosen' => 'Dr. Syahrul, S.Pd.I., M.Pd.'],
            ['nip' => '198902232019031008', 'nama_dosen' => 'Adzil Arsyi Sabana, S.E., M.E.'],
            ['nip' => '199011082019032021', 'nama_dosen' => 'Kiki Novita Sari, S.H.I., M.E.'],
            ['nip' => '199309302020121016', 'nama_dosen' => 'Miftahur Rahman Hakim, S.E.I., M.E.'],
            ['nip' => '198905232019031010', 'nama_dosen' => 'Alwahidin, S.Si., M.Sc.'],
            ['nip' => '196312311992032010', 'nama_dosen' => 'Dra. Beti Mulu, M.Pd.I.'],
            ['nip' => '197009182000031001', 'nama_dosen' => 'Dr. Wahyudin Maguni, S.E., M.Si.'],
            ['nip' => '197401092005012001', 'nama_dosen' => 'Dr. Ummi Kalsum, M.Ag.'],
            ['nip' => '197003212000031001', 'nama_dosen' => 'Alfian Toar, S.P., M.M.'],
            ['nip' => '197712182009121003', 'nama_dosen' => 'Dr. Akmal, M.E.'],
            ['nip' => '197804122009121002', 'nama_dosen' => 'Dr. Sodiman, M.Ag.'],
            ['nip' => '198810082019031005', 'nama_dosen' => 'Dr. Muljibir Rahman, S.E.I., M.E.Sy.'],
            ['nip' => '198611212019031003', 'nama_dosen' => 'Muhammad Imran, S.E., M.Ak.'],
            ['nip' => '198904012019031014', 'nama_dosen' => 'Mahfudz, Lc., M.E.'],
            ['nip' => '198805112019031010', 'nama_dosen' => 'Miswar Rohansyah, S.E., M.S.A.'],
            ['nip' => '199010242019032022', 'nama_dosen' => 'Dewi Santri, S.Si., M.Si.'],
            ['nip' => '197705232023211000', 'nama_dosen' => 'Agus Prio Utomo, S.E., M.Si.'],
            ['nip' => '197702232023211003', 'nama_dosen' => 'Sumiyadi, S.E., M.E.'],
            ['nip' => '197405312009031002', 'nama_dosen' => 'Dr. Suman Anselah, S.E., M.Si.'],
            ['nip' => '199211272020121013', 'nama_dosen' => 'Muhamad Tonasa, S.Ak., M.Ak.'],
            ['nip' => '199005062020122024', 'nama_dosen' => 'Arlita Aristianingsih Jufra, S.Si., M.E.'],
            ['nip' => '199205302020122025', 'nama_dosen' => 'Anita Rezki, S.Pd., M.Pd.'],
            ['nip' => '199009242020121007', 'nama_dosen' => 'Randy Ariyadita Putra, S.E., M.Ak., Ak., CA.'],
            ['nip' => '199403032020121015', 'nama_dosen' => 'Jafarudin, S.Pd., M.Pd.'],
            ['nip' => '199312082020122026', 'nama_dosen' => 'Lestari Daswan, S.M., M.M.'],
            ['nip' => '198102282011012000', 'nama_dosen' => 'Lily Ulfia, S.E., M.E.'],
            ['nip' => '198810162022031001', 'nama_dosen' => 'Dr. Munadi Idris, S.H.I., M.E.'],
            ['nip' => '199501252022032005', 'nama_dosen' => 'Evie Sukma, S.E., M.Ak.'],
            ['nip' => '196807022000031007', 'nama_dosen' => 'Dr. Jalaluddin Rum, S.E., M.Si.'],
            ['nip' => '20211101014',        'nama_dosen' => 'Salehaman, S.Hut., M.E.I.'],
            ['nip' => '20211102004',        'nama_dosen' => 'Indra Nola, S.E., M.E.'],
            ['nip' => '20211102015',        'nama_dosen' => 'Sitti Nur Annisa Amalia, S.H.I., M.E.'],
        ];

        // Memetakan array untuk menambahkan timestamp pada setiap record
        $dataToInsert = array_map(function ($item) use ($now) {
            return [
                'nip'              => $item['nip'],
                'nama_dosen'       => $item['nama_dosen'],
                'kuota_pembimbing' => 0, // Mengambil nilai default tabel
                'kuota_penguji'    => 0, // Mengambil nilai default tabel
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }, $dosen);

        // Memasukkan data secara massal agar lebih cepat
        DB::table('dosen')->insert($dataToInsert);
    }
}
