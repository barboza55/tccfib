<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    public function zipCodes(){
        return $this->hasMany(ZipCode::class);
    }

    public function states(){
        return $this->belongsToMany(State::class,'zip_code');
    }

    public function countrie(){
        return $this->belongsToMany(Country::class,'zip_code');
    }
}
