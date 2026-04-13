<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    // protected $fillable = ['nama_kegiatan', 'slug', 'tgl_kegiatan', 'tempat'];
    protected $fillable = ['nama_kegiatan', 'slug', 'tgl_kegiatan', 'tempat', 'created_by'];


    public function details()
    {
        return $this->hasMany(PresenceDetail::class);
    }

    public function photos()
    {
        return $this->hasMany(PresencePhoto::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
