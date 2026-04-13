<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat_nde',
        'nama_pemesan',
        'jumlah_peserta',
        'layout_ruangan',
        'unit_kerja',
        'tahun_anggaran_rapat',
        'agenda_rapat',
        'tanggal_rapat',
        'jam_rapat',
        'unggah_dokumen_nde',
        'menu_konsumsi',
        'total_biaya',
        'distribusi_tujuan',
        'lokasi_unit_kerja',
        'catatan',
        'status',
        'user_id',
        'role_tujuan',
    ];

    protected $casts = [
        'menu_konsumsi' => 'array',
        'tanggal_rapat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
