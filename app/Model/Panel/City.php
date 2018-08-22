<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function state()
    {
    	return $this->belongsTo('App\Model\State');
    }

    public function zipCodes()
    {
        return $this->hasMany('App\Model\Panel\ZipCode');
    }
}
