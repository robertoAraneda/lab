<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public function reference_ranges()
    {
        return $this->belongsTo(ReferenceRange::class);
    }
}
