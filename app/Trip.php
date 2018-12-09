<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    public $fillable = ['start_date','end_date','budget','city','state'];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function transactions(){
      return $this->hasMany('App\Transaction');
    }
}
