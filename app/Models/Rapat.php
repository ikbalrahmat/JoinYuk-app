<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rapat',
        'tanggal',
        'tempat',
        'pic_rapat',
        'catatan',
        'user_id',
    ];

    public function agendaRapat(): HasMany
    {
        return $this->hasMany(AgendaRapat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
