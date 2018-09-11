<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model{
  
  public function zipCodes(){
    return $this->belongsToMany(ZipCode::class,'address_compose');
  }

  public function streets(){
    return $this->belongsToMany(Street::class,'address_compose');
  }

  public function districts(){
    return $this->belongsToMany(District::class,'address_compose');
  }

}
