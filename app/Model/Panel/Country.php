<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function zipCodes(){
        return $this->hasMany(ZipCode::class);
    }

    public function states(){
        return $this->belongsToMany(State::class,'zip_code');
    }

    public function cities(){
        return $this->belongsToMany(City::class,'zip_code');
    }
}
