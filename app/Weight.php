<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = ['week','weight'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
