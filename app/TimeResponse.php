<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeResponse extends Model
{
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }


    public function created_user(){
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
