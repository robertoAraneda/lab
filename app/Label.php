<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function analytes(){
        return $this->belongsToMany(Analyte::class)->withTimestamps();
    }
}
