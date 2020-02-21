<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
