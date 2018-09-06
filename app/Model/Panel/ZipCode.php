<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function contry(){
        return $this->belongsTo(Country::class);
    }

    public function districts(){
        return $this->belongsToMany(District::class,'address_compose');
    }

    public function streets(){
        return $this->belongsToMany(Street::class,'address_compose');
    }

}
