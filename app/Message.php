<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    public function messagable(){
      return $this->morphTo();
    }

    public function user(){
      return $this->belongsTo('App\User');
    }
}
