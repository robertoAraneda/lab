<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfinityTypeTube extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function infinitySample()
    {
        return $this->belongsTo(InfinitySample::class, 'infinity_sample_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
