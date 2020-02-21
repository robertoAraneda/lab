<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function referenceRanges(){
        return $this->hasMany(ReferenceRange::class);
    }
}
