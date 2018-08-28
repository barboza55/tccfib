<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCodeDistrict extends Model
{
    public function dataSource(){
        return $this->belongsTo(DataSource::class);
    }

    public function zipCode(){
        return $this->belongsTo(ZipCode::class);
    }

    public function districts(){
        return $this->belongsTo(District::class);
    }
}
