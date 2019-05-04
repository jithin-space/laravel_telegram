<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    //

    public function message(){

      return $this->morphOne('App\Message','messagable');
    }
}
