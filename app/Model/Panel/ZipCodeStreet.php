<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class ZipCodeStreet extends Model
{
    public function dataSource()
    {
        return $this->belongsTo('App\Model\Panel\DataSource');
    }

    public function zipCode()
    {
        return $this->belongsTo('App\Model\Panel\ZipCode');
    }
}
