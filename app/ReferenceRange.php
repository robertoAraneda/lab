<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenceRange extends Model
{
    public function ageUnit(){
        return $this->belongsTo(AgeUnit::class, 'age_unit_id');
    }

    public function test(){
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function createdUser(){
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser(){
        return $this->belongsTo(User::class, 'updated_user_id');
    }


}
