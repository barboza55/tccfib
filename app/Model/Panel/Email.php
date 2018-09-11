<?php

namespace App\Model\Panel;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function typeEmail(){
        return $this->belongsTo(TypeEmail::class);
    }
}
