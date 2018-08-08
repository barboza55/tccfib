<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVoting extends Model
{
    public function vote(){
    	return $this->belongsTo('App\Vote');
    }

    public function typeVote(){
    	return $this->belongsTo('App\TypeVote');
    }
}
