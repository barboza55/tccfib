<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function typePhone(){
        return $this->belongsTo(TypePhone::class);
    }
}
