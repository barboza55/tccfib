<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPassword extends Model
{

	protected $fillable = [
	    'user', 'password'
	];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
