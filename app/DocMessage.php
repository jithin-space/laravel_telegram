<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocMessage extends Model
{
    //

    public function message(){

      return $this->morphOne('App\Message','messagable');
    }
}
