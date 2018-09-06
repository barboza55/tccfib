<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function zipCodes(){
        return $this->belongsToMany(ZipCode::class,'address_compose');
    }

    public function streets(){
        return $this->belongsToMany(Street::class,'address_compose');
    }

    public function dataSources(){
        return $this->belongsToMany(DataSource::class,'address_compose');
    }
}
