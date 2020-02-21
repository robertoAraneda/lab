<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityTypeTube extends Model
{
    public function state_id()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function infinity_sample_id()
    {
        return $this->belongsTo(InfinitySample::class, 'infinity_sample_id');
    }

    public function label_id()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
