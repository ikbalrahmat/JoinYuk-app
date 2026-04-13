<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'judul',
        'file_path',
        'user_id',
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
