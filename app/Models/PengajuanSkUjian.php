<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanSkUjian extends Model
{
    protected $table = 'pengajuan_sk_ujian';

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
        'jenis_ujian',
        'judul_skripsi',
        'tanggal_ujian',
        'waktu_ujian',
        'ruangan_ujian',
        'pembimbing_1_id',
        'pembimbing_2_id',
        'ketua_penguji_id',
        'sekretaris_id',
        'anggota_1_id',
        'anggota_2_id',
        'sk_pembimbing_luar_sistem',
        'path_sk_pembimbing_lama',
        'status',
        'catatan_admin',
    ];

    // Casts tanggal agar otomatis menjadi objek Carbon/Date saat dipanggil di View
    protected $casts = [
        'tanggal_ujian' => 'date',
        'sk_pembimbing_luar_sistem' => 'boolean',
    ];

    /* --- RELASI KE DOSEN PEMBIMBING --- */

    public function pembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_1_id');
    }

    public function pembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_2_id');
    }

    /* --- RELASI KE FORMASI TIM PENGUJI --- */

    public function ketuaPenguji(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'ketua_penguji_id');
    }

    public function sekretaris(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'sekretaris_id');
    }

    public function anggota1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'anggota_1_id');
    }

    public function anggota2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'anggota_2_id');
    }
}
