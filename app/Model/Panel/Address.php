<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function addressCompose(){
        return $this->belongsTo(AddressCompose::class);
    }

    public function typeAddress(){
        return $this->belongsTo(TypeAddress::class);
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
    }
}
