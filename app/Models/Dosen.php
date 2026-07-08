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

    // Hitung beban tugas (Bimbingan & Menguji) 2 minggu terakhir
    public function bebanDuaMinggu()
    {
        // Rentang: 1 minggu ke belakang sampai 1 minggu ke depan
        $start = \Carbon\Carbon::now()->subWeek()->startOfDay();
        $end = \Carbon\Carbon::now()->addWeek()->endOfDay();

        $bimbingan = \Illuminate\Support\Facades\DB::table('pengajuan_sk_pembimbing')
            ->whereIn('status', ['siap_dicetak', 'selesai'])
            ->whereBetween('updated_at', [$start, $end])
            ->where(function ($q) {
                $q->where('pembimbing_1_id', $this->id)
                    ->orWhere('pembimbing_2_id', $this->id);
            })
            ->count();

        $ujian = \Illuminate\Support\Facades\DB::table('pengajuan_sk_ujian')
            ->whereIn('status', ['siap_dicetak', 'selesai'])
            ->whereBetween('updated_at', [$start, $end])
            ->where(function ($q) {
                $q->where('ketua_penguji_id', $this->id)
                    ->orWhere('sekretaris_id', $this->id)
                    ->orWhere('anggota_1_id', $this->id)
                    ->orWhere('anggota_2_id', $this->id);
            })
            ->count();

        return "- ±1 Minggu: {$bimbingan} Bim | {$ujian} Pgj";
    }
}
