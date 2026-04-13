<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['judul', 'deadline', 'status', 'user_id'];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
