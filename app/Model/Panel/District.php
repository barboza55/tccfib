<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function zipCodeDistricts(){
        return $this->hasMany(zipCodeDistrict::class);
    }
}
