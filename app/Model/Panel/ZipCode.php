<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public function city()
    {
        return $this->belongsTo('App\Model\Panel\City');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\Panel\State');
    }

    // a partir daqui é o luidy
    public function zipCodeStreets(){
        return $this->hasMany(ZipCodeStreet::class);
    }

    public function zipCodeDistricts(){
        return $this->hasMany(ZipCodeDistrict::class);
    }

}
