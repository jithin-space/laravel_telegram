<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    public function messagable(){
      return $this->morphTo();
    }
}
