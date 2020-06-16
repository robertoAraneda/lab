<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleCondition extends Model
{

  public function analytes()
  {
    return $this->belongsToMany(Analyte::class)->withTimestamps();
  }

  public function state()
  {
    return $this->belongsTo(State::class);
  }

  public function createdUser()
  {
    return $this->belongsTo(User::class);
  }

  public function updatedUser()
  {
    return $this->belongsTo(User::class);
  }
}
