<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Risalah extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'presence_id',
        'agenda',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'pimpinan',
        'pencatat',
        'jenis_rapat',
        'penjelasan',
        'kesimpulan',
        'user_id', // ✅ tambahin
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class);
    }

    public function presence(): BelongsTo
    {
        return $this->belongsTo(Presence::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
