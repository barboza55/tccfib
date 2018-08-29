<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function contry(){
        return $this->belongsTo(Country::class);
    }

    // a partir daqui é o luidy
    public function zipCodeStreets(){
        return $this->hasMany(ZipCodeStreet::class);
    }

    public function zipCodeDistricts(){
        return $this->hasMany(ZipCodeDistrict::class);
    }

}
