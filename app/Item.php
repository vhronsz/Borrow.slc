<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //
    use SoftDeletes;

    public function detailItemTransaction(){
        return $this->belongsTo('App\DetailRoomTransaction');
    }
}
