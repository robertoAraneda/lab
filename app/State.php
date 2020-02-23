<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function referenceRanges()
    {
        return $this->hasMany(ReferenceRange::class);
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
