<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    // Mengunci nama tabel karena berbentuk tunggal (bukan plural 'dosens')
    protected $table = 'dosen';

    protected $fillable = [
        'nip',
        'nama_dosen',
        'kuota_pembimbing',
        'kuota_penguji',
    ];

    /**
     * Relasi ke data Pengajuan SK Pembimbing sebagai Pembimbing 1
     */
    public function bimbinganPembimbing1(): HasMany
    {
        return $this->hasMany(PengajuanSkPembimbing::class, 'pembimbing_1_id');
    }

    /**
     * Relasi ke data Pengajuan SK Pembimbing sebagai Pembimbing 2
     */
    public function bimbinganPembimbing2(): HasMany
    {
        return $this->hasMany(PengajuanSkPembimbing::class, 'pembimbing_2_id');
    }
}
