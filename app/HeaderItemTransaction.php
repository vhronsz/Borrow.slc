<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderItemTransaction extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey = 'itemTransactionID';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailItemTransaction(){
        return $this->hasMany(DetailItemTransaction::class,'itemTransactionID','itemTransactionID');
    }

    public function admin(){
        return $this->belongsTo('App\Admin','adminID');
    }

    public function user(){
        return $this->hasOne('App\User','userID');
    }
}
