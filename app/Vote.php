<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function itemVotings(){
    	return $this->hasMany('App\ItemVoting');
    }
}
