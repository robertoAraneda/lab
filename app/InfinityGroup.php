<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityGroup extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function infinity_supergroup_id()
    {
        return $this->belongsTo(InfinitySupergroup::class, 'infinity_supergroup_id');
    }
}
