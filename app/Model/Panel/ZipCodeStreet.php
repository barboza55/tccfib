<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCodeStreet extends Model
{
    public function dataSources(){
        return $this->belongsTo(DataSource::class);
    }
    
    public function zipCode(){
        return $this->belongsTo(ZipCode::class);
    }

    public function streets(){
        return $this->belongsTo(Street::class);
    }
    
}
