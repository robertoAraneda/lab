<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinitySupergroup extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function infinityGroups(){
        return $this->hasMany(InfinityGroup::class, 'infinity_supergroup_id');
    }
}
