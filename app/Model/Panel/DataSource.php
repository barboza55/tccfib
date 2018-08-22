<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    public function zipCodeDistricts()
    {
        return $this->hasMany('App\Model\Panel\ZipCodeDistrict');
    }
    public function zipCodeStreets()
    {
        return $this->hasMany('App\Model\Panel\ZipCodeStreet');
    }
}
