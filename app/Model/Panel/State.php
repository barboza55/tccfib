<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    public function zipCodes(){
        return $this->hasMany(ZipCode::class);
    }

    public function countries(){
        return $this->belongsToMany(Country::class,'zip_code');
    }

    public function cities(){
        return $this->belongsToMany(City::class,'zip_code');
    }
    
}
