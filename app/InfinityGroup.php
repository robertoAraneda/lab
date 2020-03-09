<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityGroup extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function infinitySupergroup()
    {
        return $this->belongsTo(InfinitySupergroup::class, 'infinity_supergroup_id');
    }

    public function infinityTests(){
        return $this->belongsToMany(InfinityTest::class, 'infinity_rel_group_tests');

    }

}
