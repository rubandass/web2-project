<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sleep extends Model
{
    protected $fillable = ['date','time'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
