<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class room extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    public function detailRoomTransaction(){
        return $this->belongsTo('App\DetailRoomTransaction','roomTransactionID');
    }
}
