<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    public function zipCodes(){
        return $this->belongsToMany(ZipCode::class,'address_compose');
    }

    public function districts(){
        return $this->belongsToMany(District::class,'address_compose');
    }

    public function dataSources(){
        return $this->belongsToMany(DataSource::class,'address_compose');
    }

}
