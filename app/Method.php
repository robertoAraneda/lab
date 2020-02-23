<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

      public function created_user(){
        return $this->belongsTo(State::class, 'created_user_id');
    }

      public function updated_user(){
        return $this->belongsTo(State::class, 'updated_user_id');
    }
}
