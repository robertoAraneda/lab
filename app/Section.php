<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
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
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function workareas(){
        return $this->hasMany(Workarea::class, 'section_id');
    }
}
