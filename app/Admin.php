<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admin extends Model
{
    //
    use SoftDeletes;

    public function roomTransaction(){
        return $this->hasMany('App\HeaderRoomTransaction');
    }

    public function itemTransaction(){
        return $this->hasMany('App\HeaderItemTransaction');
    }
}
