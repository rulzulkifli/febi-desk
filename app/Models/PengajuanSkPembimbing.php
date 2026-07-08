<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanSkPembimbing extends Model
{
    protected $table = 'pengajuan_sk_pembimbing';

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
        'judul_skripsi',
        'no_hp',
        'path_file_syarat',
        'pembimbing_1_id',
        'pembimbing_2_id',
        'status',
        'catatan_admin',
    ];

    /**
     * Relasi balik mendapatkan data Dosen Pembimbing 1
     */
    public function pembimbing1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_1_id');
    }

    /**
     * Relasi balik mendapatkan data Dosen Pembimbing 2
     */
    public function pembimbing2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_2_id');
    }

    public function programStudi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ProgramStudi::class, 'prodi');
    }
}
