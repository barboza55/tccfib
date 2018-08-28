<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
  public function zipCodeStreets(){
    return $this->hasMany(ZipCodeStreet::class);
  }

  public function zipCodeDistricts(){
    return $this->hasMany(zipCodeDistrict::class);
  }
}
