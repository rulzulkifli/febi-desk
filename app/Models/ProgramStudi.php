<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    // WAJIB: Beri tahu Laravel nama tabel aslinya. 
    // Jika tidak, Laravel akan berasumsi nama tabelnya "program_studis" (penambahan 's' gaya bahasa Inggris).
    protected $table = 'program_studi';

    // Daftarkan kolom apa saja yang boleh diisi/disimpan datanya
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'singkatan',
        'jenjang',
        'akreditasi'
    ];
}
