<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    public function user(){
        return $this->belongsTo('App\User','userID');
    }
}
