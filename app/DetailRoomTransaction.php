<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRoomTransaction extends Model
{
    //
    use SoftDeletes;

    public function headerRoomTransaction(){
        return $this->belongsTo('App\HeaderRoomTransaction');
    }

    public function room(){
        return $this->hasOne('App\Room');
    }

    public function user1(){
        return $this->hasOne('App\User');
    }

    public function user2(){
        return $this->hasOne('App\User');
    }
}
