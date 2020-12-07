<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name','user_id'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function workouts()
    {
        return $this->hasMany('App\Workout');
    }
}
