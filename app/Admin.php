<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admin extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    public function roomTransaction(){
        return $this->hasMany('App\HeaderRoomTransaction','roomTransactionID');
    }

    public function itemTransaction(){
        return $this->hasMany('App\HeaderItemTransaction','itemTransactionID');
    }
}
