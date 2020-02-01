<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'itemID';
    public function detailItemTransaction(){
        return $this->belongsTo('App\DetailItemTransaction','itemTransactionID');
    }
}
