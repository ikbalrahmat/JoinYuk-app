<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Undangan extends Model
{
    use HasFactory;

    protected $table = 'undangan';

    protected $fillable = [
        'tanggal',
        'jam',
        'kepada',
        'pengirim',
        'tempat_link',
        'agenda',
        'tanda_tangan',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
