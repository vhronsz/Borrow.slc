<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderRoomTransaction extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey = 'roomTransactionID';

    public function admin(){
        return $this->belongsTo('App\Admin','adminID');
    }

    public function roomTransaction(){
        return $this->hasMany('App\DetailRoomTransaction','roomTransactionID');
    }



}
