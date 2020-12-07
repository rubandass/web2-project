<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = ['distance','start_time','end_time', 'time','date'];
    public $timestamps = false;
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }
}
