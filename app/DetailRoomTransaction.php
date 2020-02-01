<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRoomTransaction extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;


    public function headerRoomTransaction(){
        return $this->belongsTo(HeaderItemTransaction::class,'roomTransactionID','roomTransactionID');
    }

    public function room(){
        return $this->hasOne('App\Room','roomID');
    }

    public function user1(){
        return $this->hasOne('App\User','userID');
    }

    public function user2(){
        return $this->hasOne('App\User','userID');
    }
}
