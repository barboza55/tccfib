<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class TypeAddress extends Model
{
    public function adresses(){
        return $this->hasMany(Address::class);
    }
}
