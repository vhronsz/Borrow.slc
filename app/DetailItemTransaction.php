<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailItemTransaction extends Model
{
    //
    use SoftDeletes;

    public function item(){
        return $this->hasOne('App\Item');
    }

    public function headerItemTransaction(){
        return $this->belongsTo('App\HeaderItemTransaction');
    }
}
