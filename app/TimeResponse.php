<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeResponse extends Model
{
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    
}
