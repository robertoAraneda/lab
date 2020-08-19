<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeResponseAnalyteDetail extends Model
{

  public function timeResponseUrg()
  {
    return $this->belongsTo(TimeResponse::class, 'time_response_id_urgency');
  }

  public function timeResponseHosp()
  {
    return $this->belongsTo(TimeResponse::class, 'time_response_id_hospitalized');
  }

  public function timeResponseExt()
  {
    return $this->belongsTo(TimeResponse::class, 'time_response_id_external');
  }

  public function timeResponseAmb()
  {
    return $this->belongsTo(TimeResponse::class, 'time_response_id_ambulatory');
  }

  public function analyte()
  {
    return $this->belongsTo(Analyte::class, 'analyte_id');
  }

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
}
