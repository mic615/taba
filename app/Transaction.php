<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public $fillable = ['amount','category','name','transaction_type','date','location'];

    public function trip(){
      return $this->belongsTo('App\Trip');
    }
}
