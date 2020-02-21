<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityTest extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function infinity_type_tube_id()
    {
        return $this->belongsTo(InfinityTypeTube::class, 'infinity_type_tube_id');
    }


    public function created_user_id()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updated_user_id()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

}
