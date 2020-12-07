<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['description'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
