<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model
{
    // Tambahin 'np' di sini
    // protected $fillable = ['presence_id', 'nama', 'np', 'jabatan', 'asal_instansi', 'tanda_tangan'];
    protected $fillable = ['presence_id', 'nama', 'np', 'jabatan', 'asal_instansi', 'tanda_tangan'];

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
