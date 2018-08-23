<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCodeStreet extends Model
{
    public function dataSources()
    {
        return $this->hasMany('App\Model\Panel\DataSource');
    }
    public function zipCodes()
    {
        return $this->hasMany('App\Model\Panel\ZipCode');
    }
    public function streets()
    {
        return $this->hasMany('App\Model\Panel\Street');
    }
    
}
