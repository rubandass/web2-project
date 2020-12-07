<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    protected $fillable = ['date','calories','kj','item_id'];
    public $timestamps = false;
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
