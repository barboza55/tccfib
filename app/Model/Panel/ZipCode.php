<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public function zipCodeStreets()
    {
        return $this->hasMany('App\Model\Panel\ZipCodeStreet');
    }

    public function zipCodeDistricts()
    {
        return $this->hasMany('App\Model\Panel\ZipCodeDistrict');
    }
}
