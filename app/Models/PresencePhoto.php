<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresencePhoto extends Model
{
    protected $fillable = ['presence_id', 'filename'];

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }
}

