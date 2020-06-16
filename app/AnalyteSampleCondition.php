<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyteSampleCondition extends Model
{
  protected $table = 'analyte_sample_condition';

  public function analyte()
  {
    return $this->belongsTo(Analyte::class, 'analyte_id');
  }

  public function sampleCondition()
  {
    return $this->belongsTo(SampleCondition::class, 'sample_condition_id');
  }
}
