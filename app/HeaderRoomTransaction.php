<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderRoomTransaction extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey = 'roomTransactionID';
    protected $keyType = 'string';
    public $incrementing = false;

    public function admin(){
        return $this->belongsTo('App\Admin','adminID');
    }

    public function roomTransaction(){
        return $this->hasMany(DetailRoomTransaction::class,'roomTransactionID','roomTransactionID');
    }

    public function getRoomTransactionAttribute(){
        return DetailRoomTransaction::where('roomTransactionID',$this->roomTransactionID)->get();
    }



}
