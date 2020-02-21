<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function tests(){
        return $this->belongsTo(Test::class);
    }
}
