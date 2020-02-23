<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public function reference_ranges()
    {
        return $this->belongsTo(ReferenceRange::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
