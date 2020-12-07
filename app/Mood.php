<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $fillable = ['date','mood'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
