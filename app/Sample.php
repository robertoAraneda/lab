<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function collection_methods(){
        return $this->belongsToMany(CollectionMethod::class)->withTimestamps();;
    }
}
