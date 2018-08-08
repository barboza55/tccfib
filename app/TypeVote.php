<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeVote extends Model
{
    public function itemVotings(){
    	return $this->hasMany('App\ItemVoting');
    }
}
