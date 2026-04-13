<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaRapat extends Model
{
    use HasFactory;
    protected $table = 'agenda_rapats';

    protected $fillable = [
        'rapat_id',
        'jam',
        'agenda',
        'pic',
    ];

    public function rapat(): BelongsTo
    {
        return $this->belongsTo(Rapat::class);
    }
}
