<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    public function zipCodeStreets(){
        return $this->hasMany(ZipCodeStreet::class);
    }
}
