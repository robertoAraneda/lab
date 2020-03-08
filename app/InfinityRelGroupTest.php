<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityRelGroupTest extends Model
{
    protected $table = 'infinity_rel_group_tests';

    public function infinityTest()
    {
        return $this->belongsTo(InfinityTest::class, 'infinity_test_id');

    }

    public function infinityGroup()
    {
        return $this->belongsTo(InfinityGroup::class, 'infinity_group_id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function createdUser(){
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser(){
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
