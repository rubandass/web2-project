<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alcohol extends Model
{
    protected $fillable = ['date','standard_drink','calories','kj','item_id'];
    public $timestamps = false;
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
