<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class AddressCompose extends Model
{
    public function street(){
        return $this->belongsTo(Street::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function zipCode(){
        return $this->belongsTo(ZipCode::class);
    }

    public function dataSource(){
        return $this->belongsTo(DataSource::class);
    }

    public function adresses(){
        return $this->hasMany(Address::class);
    }
}
