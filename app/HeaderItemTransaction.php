<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderItemTransaction extends Model
{
    //
    use SoftDeletes;

    public function detailItemTransaction(){
        return $this->hasMany('App\DetailRoomTransaction');
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function user(){
        return $this->hasOne('App\User');
    }
}
