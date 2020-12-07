<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'category','user_id'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function alcohols()
    {
        return $this->hasMany('App\Alcohol');
    }

    public function snacks()
    {
        return $this->hasMany('App\Snack');
    }
}
