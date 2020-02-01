<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailItemTransaction extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    protected $primaryKey = 'itemTransactionID';
    public $incrementing = false;

    public function item(){
        return $this->hasOne('App\Item','itemID','itemID');
    }

    public function headerItemTransaction(){
        return $this->belongsTo('App\HeaderItemTransaction','itemTransactionID','itemTransactionID');
    }
}
