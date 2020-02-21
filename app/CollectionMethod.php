<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionMethod extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function samples(){
        return $this->belongsToMany(Sample::class)->withTimestamps();
    }
}
