<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function adresses(){
        return $this->hasMany(Address::class);
    }

    public function emails(){
        return $this->hasMany(Email::class);
    }

    public function phones(){
        return $this->hasMany(Phone::class);
    }


}
