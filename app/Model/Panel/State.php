<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function cities()
    {
        return $this->hasMany('App\Model\City');
    }
    
}
